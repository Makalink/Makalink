import React from 'react';

import Avatar from '../../../avatar/Avatar';

import BadgeVerified from '../../../badge/BadgeVerified';

import UserStatusLevel from '../../../user-status/user-status-level/UserStatusLevel';
import UserStatusType from '../../../user-status/user-status-type/UserStatusType';
import EditedByStatus from '../../../user-status/user-status-edited-by/EditedByStatus';

function ActivityStatusHeader(props) {
  const displayVerifiedMemberBadge = vikinger_constants.plugin_active['bp-verified-member'] && vikinger_constants.settings.bp_verified_member_display_badge_in_activity_stream && props.data.author.verified;

  const displayMembershipTag = vikinger_constants.plugin_active['pmpro-buddypress'] && vikinger_constants.settings.pmpro_bp_membership_level_tag_display_on_profile_is_enabled && props.data.author.membership;

  // console.log('ACTIVITY STATUS HEADER - ACTIVITY DATA: ', props.data);

  return (
    <div className="widget-box-status-header">
      <div className="user-status">
        <div className="user-status-avatar">
          <Avatar size="small"
                  data={props.data.author}
                  noBorder
          />
        </div>
    
        <div className="user-status-title medium">
          <a href={props.data.author.link}>{props.data.author.name}</a>
        {
          displayVerifiedMemberBadge &&
            <BadgeVerified />
        }
        {
          displayMembershipTag &&
            <UserStatusLevel  name={props.data.author.membership.name}
                              size="small"
            />
        }
        {
          (props.data.author.member_types.length > 0) && props.data.author.member_types.map((memberType => {
            const memberTypeSettings = vikinger_constants.settings.member_types[memberType];

            if (memberTypeSettings && memberTypeSettings.show_in_list === '1') {
              return (
                <UserStatusType key={memberType} name={memberType} />
              );
            }
          }))
        }
          <span dangerouslySetInnerHTML={{__html: ` ${props.data.action}`}}></span>
        {
          (props.data.component === 'groups') && (props.data.type !== 'bbp_topic_create') && (props.data.type !== 'bbp_reply_create') && (props.data.group) &&
            <React.Fragment>
              <Avatar size="micro"
                      data={props.data.group}
                      noBorder
              />
              <a href={props.data.group.link}>{props.data.group.name}</a>
            </React.Fragment>
        }
        </div>

        <div className={`user-status-text small ${props.data.last_edited ? 'user-status-text_edited' : ''}`}>
        {props.data.timestamp}
        {
          props.data.last_edited &&
            <EditedByStatus user={props.data.last_edited.user} />
        }
        </div>
      </div>
    </div>
  );
}

export { ActivityStatusHeader as default };