const getPluginStatus = () => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_status_get',
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const getSelectedPluginStatus = () => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_selected_status_get',
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const updateSelectedPluginStatus = (selectedPlugins) => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_selected_status_update',
    selected_plugins: selectedPlugins,
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const installPlugin = (pluginID) => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_install',
    plugin_id: pluginID,
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const updatePlugin = (pluginID) => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_update',
    plugin_id: pluginID,
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const activatePlugin = (pluginID) => {
  const data = {
    action: 'vikinger_backend_ajax_plugin_activate',
    plugin_id: pluginID,
    _ajax_nonce: vikingerBackendConstants.AJAXNonce
  };

  return jQuery.post(ajaxurl, data);
};

const getSelectedPluginCount = (selectedPlugins) => {
  let selectedPluginCount = 0;

  for (const selectedPlugin in selectedPlugins) {
    if (selectedPlugins[selectedPlugin]) {
      selectedPluginCount++;
    }
  }

  return selectedPluginCount;
};

const doPluginsNeedProcessing = (plugins, selectedPlugins) => {
  for (const plugin of plugins) {
    if (selectedPlugins[plugin.id] && !(plugin.installed && plugin.active && plugin.updated)) {
      return true;
    }
  }

  return false;
};

const getMessageBoxProps = (plugins, selectedPlugins, loadingPlugins) => {
  if (loadingPlugins) {
    return {
      type: 'info',
      title: vikingerBackendTranslation.pluginList.message.loading.title,
      text: vikingerBackendTranslation.pluginList.message.loading.text
    };
  }

  const selectedPluginCount = getSelectedPluginCount(selectedPlugins);

  if (selectedPluginCount === 0) {
    return {
      type: 'info',
      title: vikingerBackendTranslation.pluginList.message.no_plugins.title,
      text: vikingerBackendTranslation.pluginList.message.no_plugins.text
    };
  }

  const pluginsNeedProcessing = doPluginsNeedProcessing(plugins, selectedPlugins);

  if (pluginsNeedProcessing) {
    return {
      type: 'error',
      title: vikingerBackendTranslation.pluginList.message.error.title,
      text: vikingerBackendTranslation.pluginList.message.error.text
    };
  }

  return {
    type: 'success',
    title: vikingerBackendTranslation.pluginList.message.success.title,
    text: vikingerBackendTranslation.pluginList.message.success.text
  };
};

export {
  getPluginStatus,
  getSelectedPluginStatus,
  updateSelectedPluginStatus,
  installPlugin,
  updatePlugin,
  activatePlugin,
  getMessageBoxProps,
  doPluginsNeedProcessing
};