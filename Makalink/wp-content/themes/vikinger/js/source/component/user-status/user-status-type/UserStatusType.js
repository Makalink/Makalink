import React from 'react';

function UserStatusType(props) {
  let modifierClasses = false;

  if (props.size === 'small') {
    modifierClasses = 'vikinger-user-tag_small'
  }

  return (
    <div className={`vikinger-user-tag ${modifierClasses || ''}`}>
      <p className="vikinger-user-tag-text">{props.name}</p>
    </div>
  );
}

export { UserStatusType as default };