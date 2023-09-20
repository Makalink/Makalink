import React from 'react';
import ReactDOM from 'react-dom';

import PluginList from '../../component/plugin/PluginList';

const PluginListElement = document.querySelector('.vikinger_backend-plugin-list');

if (PluginListElement) {
  ReactDOM.render(
    <PluginList />,
    PluginListElement
  );
}