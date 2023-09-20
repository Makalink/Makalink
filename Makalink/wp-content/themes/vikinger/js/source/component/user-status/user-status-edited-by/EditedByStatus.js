import React from 'react';

import Avatar from '../../avatar/Avatar';

function EditedByStatus(props) {
  return (
    <React.Fragment>
    { vikinger_translation.edited_by }
      <Avatar
        size="micro"
        modifiers="user-status-avatar"
        data={props.user}
        noBorder
      />
      <a href={props.user.link}>{props.user.name}</a>
    </React.Fragment>
  );
}

export { EditedByStatus as default };