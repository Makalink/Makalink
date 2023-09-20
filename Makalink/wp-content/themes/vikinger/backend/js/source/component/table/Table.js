import React from 'react';

import Checkbox from '../form/Checkbox';

import ItemStatus from '../status/ItemStatus';

import Loader from '../loader/Loader';

const Table = (props) => {
  return (
    <table className="vikinger_backend-table">
      <thead>
        <tr>
        {
          props.headerData.map((headerDataItem, i) => {
            return (
              <th key={i}>{headerDataItem.text}</th>
            );
          })
        }
        </tr>
      </thead>

      <tbody>
      {
        props.bodyData.map((bodyDataItem, i) => {
          return (
            <tr key={i}>
              <td>
                <Checkbox
                  id={bodyDataItem[0].id}
                  text={bodyDataItem[0].text}
                  checked={bodyDataItem[0].checked}
                  disabled={props.disableControls}
                  onChange={(checked) => {
                    // console.log('Table - Checkbox - onChange - checked: ', bodyDataItem[0].id, checked);

                    if (typeof props.onPluginSelect === 'function') {
                      props.onPluginSelect(bodyDataItem[0].id, checked);
                    }
                  }}
                />
              </td>

              <td>
                <p>{bodyDataItem[1].text}</p>
              </td>

              <td>
                <p>{bodyDataItem[2].text}</p>
              </td>

              <td>
                <p>{bodyDataItem[3].text}</p>
              </td>

              <td>
              {
                bodyDataItem[4].loading &&
                  <Loader size="tiny" />
              }
              {
                !bodyDataItem[4].loading &&
                  <React.Fragment>
                  {
                    bodyDataItem[4].type &&
                      <ItemStatus type={bodyDataItem[4].type} />
                  }
                  {
                    bodyDataItem[4].text &&
                    <p>{bodyDataItem[4].text}</p>
                  }
                  </React.Fragment>
              }
              </td>
            </tr>
          );
        })
      }
      </tbody>
    </table>
  );
};

export { Table as default };