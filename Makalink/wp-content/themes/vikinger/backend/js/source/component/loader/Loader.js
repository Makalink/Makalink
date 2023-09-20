import React from 'react';

const Loader = (props) => {
  return (
    <div className={`vikinger_backend-loader-spinner ${props.size ? `vikinger_backend-loader-spinner_${props.size}` : ''}`}>
      <div></div>
      <div></div>
      <div></div>
    </div>
  );
};

export { Loader as default };