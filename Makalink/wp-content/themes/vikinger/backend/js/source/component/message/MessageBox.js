import React from 'react';

import Icon from '../icon/Icon';

const MessageBox = (props) => {
  return (
    <div className={`vikinger_backend-message-box vikinger_backend-message-box_${props.type}`}>
      <div className="vikinger_backend-message-box-icon-wrap">
        <Icon
          name={props.type}
          wrapperClasses={['vikinger_backend-message-box-icon']}
        />
      </div>

      <p className="vikinger_backend-message-box-title">{props.title}</p>

      <p className="vikinger_backend-message-box-text" dangerouslySetInnerHTML={{__html: props.text}}></p>
    </div>
  );
};

export { MessageBox as default };