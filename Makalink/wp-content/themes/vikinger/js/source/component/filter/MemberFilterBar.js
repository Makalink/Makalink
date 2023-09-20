import React, { useState, useRef, useEffect } from 'react';

import IconSVG from '../icon/IconSVG';

import GridOptions from '../grid/GridOptions';

import { createFormInput } from '../../utils/plugins';

const memberTypes = Object.values(vikinger_constants.settings.member_types).filter(memberType => memberType.has_directory === '1');

function MemberFilterBar(props) {
  const [type, setType] = useState('alphabetical');
  const [search, setSearch] = useState(props.searchTerm || '');
  const [memberType, setMemberType] = useState('all');

  const searchInputRef = useRef(null);

  useEffect(() => {
    if (!props.searchTerm) {
      createFormInput([searchInputRef.current]);
    }
  }, []);

  useEffect(() => {
    const filters = {type, search, member_type: memberType};

    if (memberType === 'all') {
      filters.member_type = false;
    }

    props.applyFilters(filters);
  }, [type, memberType]);

  const handleSubmit = (e) => {
    e.preventDefault();

    const filters = {type, search, member_type: memberType};

    if (memberType === 'all') {
      filters.member_type = false;
    }

    props.applyFilters(filters);
  };

  return (
    <div className="section-filters-bar v2">
      <div className="section-filters-bar-actions full">
        <form className="form" onSubmit={handleSubmit}>
          <div className="form-row split">
          {
            !props.searchTerm &&
              <div className="form-item">
                <div ref={searchInputRef} className="form-input small with-button">
                  <label htmlFor="member-name">{vikinger_translation.search_members}</label>
                  <input type="text" id="member-name" name="search" onChange={(e) => { setSearch(e.target.value); }} />

                  <button type="submit" className={`button ${props.themeColor}`}>
                    <IconSVG icon="magnifying-glass" />
                  </button>
                </div>
              </div>
          }
            <div className="form-item">
              <div className="form-select">
                <label htmlFor="member-order-by">{vikinger_translation.order_by}</label>
                <select id="member-order-by" name="type" value={type} onChange={(e) => { setType(e.target.value); }}>
                  <option value="alphabetical">{vikinger_translation.alphabetical}</option>
                  <option value="newest">{vikinger_translation.newest_members}</option>
                  <option value="active">{vikinger_translation.recently_active}</option>
                </select>
                <IconSVG
                  icon="small-arrow"
                  modifiers="form-select-icon"
                />
              </div>
            </div>
          {
            !props.memberType && (memberTypes.length > 0) &&
              <div className="form-item">
                <div className="form-select">
                  <label htmlFor="member-order-by">{vikinger_translation.member_type}</label>
                  <select id="member-order-by" name="member_type" value={memberType.name} onChange={(e) => { setMemberType(e.target.value); }}>
                    <option value="all">{vikinger_translation.all}</option>
                  {
                    memberTypes.map((memberType) => {
                      return (
                        <option key={memberType.name} value={memberType.name}>{memberType.labels.name}</option>
                      );
                    })
                  }
                  </select>
                  <IconSVG
                    icon="small-arrow"
                    modifiers="form-select-icon"
                  />
                </div>
              </div>
          }
          </div>
        </form>
      </div>

      <div className="section-filters-bar-actions">
        <GridOptions  gridTypes={['big', 'small', 'list']}
                      activeGrid={props.gridType}
                      onGridOptionClick={props.setGrid}
        />
      </div>
    </div>
  );
}

export { MemberFilterBar as default };