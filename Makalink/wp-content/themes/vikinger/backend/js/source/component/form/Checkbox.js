import React, { useState } from 'react';

import Icon from '../icon/Icon';

const Checkbox = (props) => {
  const [checked, setChecked] = useState(props.checked);

  const handleChange = (e) => {
    setChecked(e.target.checked);

    if (typeof props.onChange === 'function') {
      props.onChange(e.target.checked);
    }
  };

  return (
    <div className="vikinger_backend-checkbox-wrap">
      <input id={props.id} type="checkbox" checked={checked} disabled={props.disabled} onChange={handleChange} />

      <div className="vikinger_backend-checkbox">
        <div className="vikinger_backend-checkbox-box">
          <Icon
            name="cross"
            wrapperClasses={['vikinger_backend-checkbox-box-icon']}
          />
        </div>

        <label htmlFor={props.id}>{props.text}</label>
      </div>
    </div>
  );
};

export { Checkbox as default };