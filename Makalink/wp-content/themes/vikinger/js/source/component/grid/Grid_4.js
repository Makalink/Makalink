import React from 'react';

function Grid_4(props) {
  return (
    <div className="grid grid-4-4-4 stretched centered-on-mobile">
      {props.content}
    </div>
  );
}

export { Grid_4 as default };