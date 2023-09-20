(() => {
  'use strict';

  /**
   * Loads SVG data (wrapped in a div) at the end of the document body.
   * 
   * @since 1.0.0
   */
  const loadSVGData = () => {
    const svgWrap = document.createElement('div');
  
    const svgData = `
    <!-- SVG INFO -->
    <svg style="display: none;">
      <symbol id="svg-info" viewBox="0 0 20 20" preserveAspectRatio="xMinYMin meet">
        <path d="M9,15h2V9H9V15z M9,7h2V5H9V7z M16-0.001H4c-2.209,0-4,1.791-4,4v12c0,2.209,1.791,4,4,4h12c2.209,0,4-1.791,4-4v-12C20,1.79,18.209-0.001,16-0.001z M18,15.999C18,17.102,17.103,18,16,18H4c-1.103,0-2-0.898-2-2.001v-12c0-1.103,0.897-2,2-2h12c1.103,0,2,0.897,2,2V15.999z"/>
      </symbol>
    </svg>
    <!-- /SVG INFO -->
  
    <!-- SVG SUCCESS -->
    <svg style="display: none;">
      <symbol id="svg-success" viewBox="0 0 20 20" preserveAspectRatio="xMinYMin meet">
        <path d="M16,20H4c-2.209,0-4-1.791-4-4V4c0-2.208,1.791-4,4-4h12c2.209,0,4,1.791,4,4v12C20,18.209,18.209,20,16,20z M18,4c0-1.103-0.897-2-2-2H4C2.897,2,2,2.897,2,4v12
        c0,1.103,0.897,2.001,2,2.001h12c1.103,0,2-0.898,2-2.001V4z M4.995,10.973l1.088-1.746l3.771,2.016l3.265-5.237l1.886,1.008l-4.354,6.982L4.995,10.973z"/>
      </symbol>
    </svg>
    <!-- /SVG SUCCESS -->
  
    <!-- SVG ERROR -->
    <svg style="display: none;">
      <symbol id="svg-error" viewBox="0 0 20 20" preserveAspectRatio="xMinYMin meet">
      <path d="M16,20H4c-2.209,0-4-1.791-4-4V4c0-2.208,1.791-4,4-4h12c2.209,0,4,1.791,4,4v12C20,18.209,18.209,20,16,20z M18,4c0-1.103-0.897-2-2-2H4C2.897,2,2,2.897,2,4v12
      c0,1.103,0.897,2.001,2,2.001h12c1.103,0,2-0.898,2-2.001V4z M12.402,14.006L10,11.603l-2.403,2.403l-1.602-1.603l2.403-2.402L5.995,7.598l1.602-1.602L10,8.399l2.402-2.403l1.603,1.602l-2.403,2.403l2.403,2.402L12.402,14.006z"/>
      </symbol>
    </svg>
    <!-- /SVG ERROR -->

    <!-- SVG CROSS -->
    <svg style="display: none;">
      <symbol id="svg-cross" viewBox="0 0 12 12" preserveAspectRatio="xMinYMin meet">
        <path d="M12,9.6L9.6,12L6,8.399L2.4,12L0,9.6L3.6,6L0,2.4L2.4,0L6,3.6L9.6,0L12,2.4L8.399,6L12,9.6z"/>
      </symbol>
    </svg>
    <!-- /SVG CROSS -->

    <!-- SVG CHECK -->
    <svg style="display: none;">
      <symbol id="svg-check" viewBox="0 0 6 6" preserveAspectRatio="xMinYMin meet">
        <path d="M6.012,0.966L3.217,6.004l-3.229-1.939l0.932-1.68l1.614,0.97l1.864-3.359L6.012,0.966z"/>
      </symbol>
    </svg>
    <!-- /SVG CHECK -->
    `;
  
    svgWrap.innerHTML = svgData;
    document.body.appendChild(svgWrap);
  };
  
  window.addEventListener('DOMContentLoaded', loadSVGData);
})();