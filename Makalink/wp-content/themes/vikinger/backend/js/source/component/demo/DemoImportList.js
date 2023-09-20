import React, { useState } from 'react';

import Loader from '../loader/Loader';

import CheckBox from '../form/Checkbox';

import ItemStatus from '../status/ItemStatus';

import DemoImporter from '../utils/demo';

const demoImportListData = [
  {
    name: 'Menus',
    description: 'Creates the header menu, header features menu, side menu and footer menu, their menu items and icons and assigns them to the appropiate menu locations.',
    selected: true,
    processing: false,
    result: false,
    process: DemoImporter.createMenus,
    reset: DemoImporter.deleteMenus
  },
  {
    name: 'Base Pages',
    description: 'Creates blog page.',
    selected: true,
    processing: false,
    result: false,
    process: DemoImporter.createBasePages,
    reset: DemoImporter.deleteBasePages
  },
  {
    name: 'Elementor Pages',
    description: 'Creates landing page. You will still need to import the page template by editing this page with Elementor, check the <a href="https://odindesignthemes.com/vikingerthemedocs/landing-page/" target="_blank">documentation</a> "Elementor" section for a tutorial on how to import the landing page template with Elementor.',
    selected: true,
    processing: false,
    result: false,
    process: DemoImporter.createElementorPages,
    reset: DemoImporter.deleteElementorPages
  },
  {
    name: 'GamiPress Pages',
    description: 'Creates badges, quests, ranks and credits pages. You will still need to import the badges, quests, ranks and credits data by using the GamiPress Import Tools, check the <a href="https://odindesignthemes.com/vikingerthemedocs/demo-content/" target="_blank">documentation</a> "GamiPress" -> "Demo Content" section for a tutorial on how to import this data.',
    selected: true,
    processing: false,
    result: false,
    process: DemoImporter.createGamiPressPages,
    reset: DemoImporter.deleteGamiPressPages
  },
  {
    name: 'BuddyPress xProfile Groups',
    description: 'Creates buddypress xprofile field groups and their respective fields (like the About and Social Networks fields).',
    selected: true,
    processing: false,
    result: false,
    process: DemoImporter.createBuddyPressProfileFieldGroups,
    reset: DemoImporter.deleteBuddyPressProfileFieldGroups
  }
];

const DemoImportList = (props) => {
  const [demoImportData, setDemoImportData] = useState(demoImportListData);

  const [processingImport, setProcessingImport] = useState(false);
  const [processingReset, setProcessingReset] = useState(false);

  const toggleSelected = (i) => {
    // do not allow selection interaction if already processing
    if (processingImport || processingReset) {
      return;
    }

    const importData = demoImportData.slice();

    importData[i].selected = !importData[i].selected;

    setDemoImportData(importData);
  };

  const noOptionsAreSelected = () => {
    for (const importItem of demoImportData) {
      if (importItem.selected) {
        return false;
      }
    }

    return true;
  };

  const processImport = (importData, i, callback) => {
    // console.log('DEMO IMPORT LIST - PROCESS IMPORT: ', i);

    const importItem = importData[i];

    // item is not selected, do not process
    if (!importItem.selected) {
      // reached last item, finish
      if (i === (importData.length - 1)) {
        callback();
      } else {
        processImport(importData, i + 1, callback);
      }
    } else {
      importItem.processing = true;

      setDemoImportData(importData);

      importItem.process()
      .done((response) => {
        // console.log('DEMO IMPORT LIST - IMPORT ITEM PROCESS RESPONSE: ', response);

        if (response) {
          importItem.result = 'success';
        } else {
          importItem.result = 'error';
        }
      })
      .fail((error) => {
        // console.log('DEMO IMPORT LIST - IMPORT ITEM PROCESS ERROR: ', error);

        importItem.result = 'error';
      })
      .always(() => {
        importItem.processing = false;

        setDemoImportData(importData);

        // reached last item, finish
        if (i === (importData.length - 1)) {
          callback();
        } else {
          processImport(importData, i + 1, callback);
        }
      });
    }
  };

  const processImports = (e) => {
    e.preventDefault();

    // return if already processing
    if (processingImport || processingReset || noOptionsAreSelected()) {
      return;
    }

    setProcessingImport(true);

    const importData = demoImportData.slice();

    processImport(importData, 0, () => {
      setProcessingImport(false);
    });
  };

  const resetImport = (importData, i, callback) => {
    // console.log('DEMO IMPORT LIST - RESET IMPORT: ', i);

    const importItem = importData[i];

    // item is not selected, do not process
    if (!importItem.selected) {
      // reached last item, finish
      if (i === (importData.length - 1)) {
        callback();
      } else {
        resetImport(importData, i + 1, callback);
      }
    } else {
      importItem.processing = true;

      setDemoImportData(importData);

      importItem.reset()
      .done((response) => {
        // console.log('DEMO IMPORT LIST - IMPORT ITEM RESET RESPONSE: ', response);

        if (response) {
          importItem.result = 'success';
        } else {
          importItem.result = 'error';
        }
      })
      .fail((error) => {
        // console.log('DEMO IMPORT LIST - IMPORT ITEM RESET ERROR: ', error);

        importItem.result = 'error';
      })
      .always(() => {
        importItem.processing = false;

        setDemoImportData(importData);

        // reached last item, finish
        if (i === (importData.length - 1)) {
          callback();
        } else {
          resetImport(importData, i + 1, callback);
        }
      });
    }
  };

  const resetImports = (e) => {
    e.preventDefault();

    // return if already processing
    if (processingImport || processingReset || noOptionsAreSelected()) {
      return;
    }

    setProcessingReset(true);

    const importData = demoImportData.slice();

    resetImport(importData, 0, () => {
      setProcessingReset(false);
    });
  };

  return (
    <React.Fragment>
      <table className="vikinger_backend-table">
        <thead>
          <tr>
            <th>Name</th>

            <th>Description</th>

            <th></th>
          </tr>
        </thead>

        <tbody>
        {
          demoImportData.map((importData, i) => {
            return (
              <tr key={i}>
                <td>
                  <CheckBox
                    id={`checkbox-${i}`}
                    text={importData.name}
                    checked={importData.selected}
                    onChange={() => {toggleSelected(i);}}
                  />
                </td>

                <td dangerouslySetInnerHTML={{__html: importData.description}}></td>

                <td>
                {
                  importData.processing &&
                    <Loader size="tiny" />
                }
                {
                  !importData.processing && importData.result &&
                    <ItemStatus type={importData.result} />
                }
                </td>
              </tr>
            );
          })
        }
        </tbody>
      </table>

      <div className="vikinger_backend-button-wrap vikinger_backend-button-wrap_align-right">
        <a className="vikinger_backend-button" href="#" onClick={resetImports}>
        {
          processingReset && 'Resetting...'
        }
        {
          !processingReset && 'Reset'
        }
        </a>

        <a className="vikinger_backend-button vikinger_backend-button_primary" href="#" onClick={processImports}>
        {
          processingImport && 'Importing...'
        }
        {
          !processingImport && 'Import'
        }
        </a>
      </div>
    </React.Fragment>
  );
};

export { DemoImportList as default };