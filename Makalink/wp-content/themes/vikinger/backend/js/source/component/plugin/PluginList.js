import React, { useState, useEffect } from 'react';

import MessageBox from '../message/MessageBox';

import Table from '../table/Table';

import Loader from '../loader/Loader';

import {
  getPluginStatus,
  getSelectedPluginStatus,
  updateSelectedPluginStatus,
  installPlugin,
  updatePlugin,
  activatePlugin,
  getMessageBoxProps,
  doPluginsNeedProcessing
} from './pluginList-utils';

const PluginList = (props) => {
  const [plugins, setPlugins] = useState([]);
  const [loadingPlugins, setLoadingPlugins] = useState(true);

  const [selectedPlugins, setSelectedPlugins] = useState({});
  
  const [processingPluginID, setProcessingPluginID] = useState(false);
  const [runningSetup, setRunningSetup] = useState(false);

  useEffect(() => {
    const getPluginStatusPromise = getPluginStatus();
    const getSelectedPluginStatusPromise = getSelectedPluginStatus();

    jQuery
    .when(getPluginStatusPromise, getSelectedPluginStatusPromise)
    .done((getPluginStatusResponse, getSelectedPluginStatusResponse) => {
      // console.log('PluginList - getPluginStatus - response', getPluginStatusResponse);
      // console.log('PluginList - getSelectedPluginStatus - response', getSelectedPluginStatusResponse);

      const pluginStatusResponse = getPluginStatusResponse[0];
      const selectedPluginStatusResponse = getSelectedPluginStatusResponse[0];

      if (pluginStatusResponse && (pluginStatusResponse instanceof Array)) {
        setPlugins(pluginStatusResponse);
      }

      if (selectedPluginStatusResponse && (selectedPluginStatusResponse instanceof Object)) {
        const selectedPlugins = {};

        for (const plugin of pluginStatusResponse) {
          selectedPlugins[plugin.id] = typeof selectedPluginStatusResponse[plugin.id] !== 'undefined' ? selectedPluginStatusResponse[plugin.id] : true;
        }

        setSelectedPlugins(selectedPlugins);
      }
    })
    .always(() => {
      setLoadingPlugins(false);
    });
  }, []);

  useEffect(() => {
    // console.log('PluginList - useEffect - selectedPlugins changed: ', selectedPlugins);

    if (Object.keys(selectedPlugins).length > 0) {
      // update selected plugins
      const updateSelectedPluginStatusPromise = updateSelectedPluginStatus(selectedPlugins);

      updateSelectedPluginStatusPromise
      .done((response) => {
        // console.log('PluginList - useEffect - updateSelectedPluginStatus - response', response);
      });
    }
  }, [selectedPlugins]);

  const handlePluginSelect = (pluginID, selected) => {
    setSelectedPlugins((previousSelectedPlugins) => {
      const newSelectedPlugins = {
        ...previousSelectedPlugins,
        [pluginID]: selected
      };

      // console.log('PluginList - handlePluginSelect - selectedPlugins: ', newSelectedPlugins);

      return newSelectedPlugins;
    });
  };

  const runSetup = (e) => {
    e.preventDefault();

    if (runningSetup) {
      return;
    }

    // console.log('Plugin List - runSetup');

    setRunningSetup(true);

    if (plugins.length) {
      runSetupItem(0);
    }
  };

  const runSetupItem = (i) => {
    // console.log('PluginList - runSetupItem - i: ', i);

    if (i >= plugins.length) {
      setRunningSetup(false);

      return;
    }

    const plugin = plugins[i];

    // if plugin is selected for processing, but not installed and updated and active
    // process it
    if (selectedPlugins[plugin.id] && !(plugin.installed && plugin.updated && plugin.active)) {
      let processPluginFunction = false;

      if (!plugin.installed) {
        // console.log('PluginList - runSetupItem - Install Plugin');

        processPluginFunction = installPlugin;
      } else if (!plugin.updated) {
        // console.log('PluginList - runSetupItem - Update Plugin');

        processPluginFunction = updatePlugin;
      } else if (!plugin.active) {
        // console.log('PluginList - runSetupItem - Activate Plugin');

        processPluginFunction = activatePlugin;
      }

      if (processPluginFunction) {
        processPlugin(processPluginFunction, plugin.id, () => {
          runSetupItem(i + 1);
        });
      } else {
        runSetupItem(i + 1);
      }
    } else {
      runSetupItem(i + 1);
    }
  };

  const processPlugin = (processPlugin, pluginID, callback = () => {}) => {
    const processPluginPromise = processPlugin(pluginID);

    setProcessingPluginID(pluginID);

    processPluginPromise
    .done((response) => {
      // console.log('PluginList - processPluginPromise - response', response);

      if (response && response.id) {
        setPlugins((previousPlugins) => {
          const newPlugins = previousPlugins.map((plugin) => {
            if (plugin.id === response.id) {
              return response;
            }

            return plugin;
          });

          return newPlugins;
        });
      }
    })
    .always(() => {
      setProcessingPluginID(false);
      callback();
    });
  };

  const headerData = [
    {
      text: 'Plugin'
    },
    {
      text: 'Installed Version'
    },
    {
      text: 'Latest Version'
    },
    {
      text: 'Active'
    },
    {
      text: ''
    }
  ];

  const bodyData = [];

  for (const plugin of plugins) {
    const pluginIsSelected = selectedPlugins[plugin.id];

    const checkboxData = {
      id: plugin.id,
      text: plugin.name,
      checked: pluginIsSelected
    };

    const installedVersionData = {
      text: '-'
    };

    if (plugin.installed) {
      installedVersionData.text = plugin.installed_version;
    }

    const latestVersionData = {
      text: plugin.latest_version
    };

    const activeData = {
      text: '-'
    };

    if (plugin.installed) {
      activeData.text = plugin.active ? 'Yes' : 'No';
    }

    const pluginIsLoading = processingPluginID === plugin.id;

    const statusData = {
      loading: pluginIsLoading
    };

    if (pluginIsSelected) {
      if (!(plugin.installed && plugin.active && plugin.updated)) {
        statusData.type = 'error';
      } else {
        statusData.type = 'success';
      }
    } else {
      statusData.text = '-';
    }

    bodyData.push(
      [
        checkboxData,
        installedVersionData,
        latestVersionData,
        activeData,
        statusData
      ]
    );
  }

  const pluginsNeedProcessing = doPluginsNeedProcessing(plugins, selectedPlugins);

  const messageBoxProps = getMessageBoxProps(plugins, selectedPlugins, loadingPlugins);

  return (
    <React.Fragment>
      <MessageBox {...messageBoxProps} />
    {
      loadingPlugins &&
        <Loader />
    }
    {
      !loadingPlugins && plugins.length &&
        <React.Fragment>
          <Table
            headerData={headerData}
            bodyData={bodyData}
            onPluginSelect={handlePluginSelect}
            disableControls={runningSetup}
          />

        {
          pluginsNeedProcessing &&
            <div className="vikinger_backend-button-wrap vikinger_backend-button-wrap_align-right">
              <a className="vikinger_backend-button" href="#" onClick={runSetup}>
              {
                runningSetup && 'Running...'
              }
              {
                !runningSetup && 'Run Setup'
              }
              </a>
            </div>
        }
        </React.Fragment>
    }
    </React.Fragment>
  );
};

export { PluginList as default };