import React from 'react';

import Icon from '../icon/Icon';

const ItemStatus = (props) => {
  const iconName = {
    success: 'check',
    error: 'cross'
  };

  return (
    <div className={`vikinger_backend-item-status vikinger_backend-item-status_${props.type}`}>
      <Icon
        name={iconName[props.type]}
        wrapperClasses={['vikinger_backend-item-status-icon']}
      />
    </div>
  );
};

export { ItemStatus as default };