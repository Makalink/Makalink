import React from 'react';

import UserStatusType from './UserStatusType';

function UserStatusTypeList(props) {
  return (
    <div className="vikinger-user-tag-list">
    {
      props.tags.map((tag) => {
        return (
          <UserStatusType
            key={tag}
            name={tag}
            size={props.size}
          />
        );
      })
    }
    </div>
  );
}

export { UserStatusTypeList as default };