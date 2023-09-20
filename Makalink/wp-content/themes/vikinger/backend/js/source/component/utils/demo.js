const DemoImporter = {
  createMenus: () => {
    const data = {
      action: 'vikinger_demo_content_menus_create_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  deleteMenus: () => {
    const data = {
      action: 'vikinger_demo_content_menus_delete_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  createBasePages: () => {
    const data = {
      action: 'vikinger_demo_content_base_pages_create_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  deleteBasePages: () => {
    const data = {
      action: 'vikinger_demo_content_base_pages_delete_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  createElementorPages: () => {
    const data = {
      action: 'vikinger_demo_content_elementor_pages_create_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  deleteElementorPages: () => {
    const data = {
      action: 'vikinger_demo_content_elementor_pages_delete_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  createGamiPressPages: () => {
    const data = {
      action: 'vikinger_demo_content_gamipress_pages_create_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  deleteGamiPressPages: () => {
    const data = {
      action: 'vikinger_demo_content_gamipress_pages_delete_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  createBuddyPressProfileFieldGroups: () => {
    const data = {
      action: 'vikinger_demo_content_buddypress_xprofile_field_groups_create_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  },
  deleteBuddyPressProfileFieldGroups: () => {
    const data = {
      action: 'vikinger_demo_content_buddypress_xprofile_field_groups_delete_ajax',
      _ajax_nonce: vikingerBackendConstants.AJAXNonce
    };

    return jQuery.post(ajaxurl, data);
  }
};

export { DemoImporter as default };