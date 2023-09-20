import React from 'react';
import ReactDOM from 'react-dom';

import DemoImportList from '../../component/demo/DemoImportList';

const demoImportListElement = document.querySelector('.vikinger_backend-demo-import-list');

if (demoImportListElement) {
  ReactDOM.render(
    <DemoImportList />,
    demoImportListElement
  );
}