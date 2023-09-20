import React from 'react';

const Icon = (props) => {
  const wrapperClasses = props.wrapperClasses && (props.wrapperClasses instanceof Array) ? props.wrapperClasses.join(' ') : '';

  return (
    <svg className={`vikinger-icon vikinger-icon_${props.name} ${wrapperClasses}`}>
      <use href={`#svg-${props.name}`}></use>
    </svg>
  );
};

export { Icon as default };