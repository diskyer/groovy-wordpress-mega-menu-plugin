import PerfectScrollbar from 'perfect-scrollbar';
import { getCoords, isMobile } from '../shared/helpers';
import _ from 'lodash';

function getFirstDropdownRect (menuItem, settings) {
  let currentDropdown = menuItem.querySelector('.gm-dropdown-menu');
  let currentDropdownWidth = currentDropdown.offsetWidth;
  let top = menuItem.offsetHeight;
  let width = currentDropdownWidth;

  if (isVerticalMenu(settings)) {
    top = 0;
  }

  return ({
    top: top,
    width: width
  });
}

function isVerticalMenu (settings) {
  let verticalMenu = false;

  let headerStyle = parseInt(settings.header.style, 10);

  if (headerStyle === 2 || headerStyle === 3 || headerStyle === 5) {
    verticalMenu = true;
  }

  return verticalMenu;
}

function getSubmenuDropdownRect (menuItem, settings, scrollbars) {
  let closestdropdownMenuPs = menuItem.closest('.gm-dropdown-menu.ps');

  if (!closestdropdownMenuPs) {
    return ({
      top: 0
    });
  }

  let psId = closestdropdownMenuPs.getAttribute('data-ps-id');
  let top = menuItem.offsetTop - scrollbars[psId].lastScrollTop;

  if (top < 0) {
    top = 0;
  }

  if (isVerticalMenu(settings)) {
    top = 0;
  }

  return ({
    top: top
  });
}


// ---------------------------------------------------------------------------------------------------------------------

export default function initScrollbar (settings) {
  // Main select fot all dropdown links.
  let dropdownMenuLinks = document.querySelectorAll('.gm-main-menu-wrapper .gm-dropdown-toggle');

  let _dropdownWrapper = document.querySelector('.gm-main-menu-wrapper .gm-dropdown-menu-wrapper');
  let _transformValuesCss = null;
  if (_dropdownWrapper) {
    _transformValuesCss = getComputedStyle(_dropdownWrapper)['transform'];
  }

  let scrollbars = [];


  function getDropdownMaxHeight(currentDropdown, isTransitionEnd) {
    let windowHeight = window.innerHeight;
    let topOffset = getCoords(currentDropdown).top;
    let topViewportOffset = topOffset - window.pageYOffset;

    let getDropdownMaxHeightValue = windowHeight - topViewportOffset;

    if (!isTransitionEnd && _transformValuesCss) {
      let transformValues = _transformValuesCss
        .replace(/[^0-9\-.,]/g, '')
        .split(',');
      let dropdownMenuTranslateY = Number(transformValues[5]) || 0;

      getDropdownMaxHeightValue = windowHeight - topViewportOffset + dropdownMenuTranslateY;
    }

    return getDropdownMaxHeightValue;
  }

  function handleScrollbarMouseEnter () {

    let parentMenuItem = this.closest('.gm-dropdown');

    if (!parentMenuItem) {
      return;
    }

    let currentDropdown = parentMenuItem.querySelector('.gm-dropdown-menu');

    if (!currentDropdown) {
      return;
    }

    let dropdownWrapper = parentMenuItem.querySelector('.gm-dropdown-menu-wrapper');
    let headerStyle = parseInt(settings.header.style, 10);
    let maxHeightCalculated = getDropdownMaxHeight(currentDropdown, false);
    if ((1 === headerStyle || 4 === headerStyle) && settings.dropdownAppearanceStyle === 'animate-from-bottom') {
      maxHeightCalculated = maxHeightCalculated + 40;
    }


    // Second and next dropdown levels ---------------------------------------------------
    if (parentMenuItem.classList.contains('gm-dropdown-submenu')) {
      let subDropdownRect = getSubmenuDropdownRect(parentMenuItem, settings, scrollbars);

      parentMenuItem.style.position = 'static';

      dropdownWrapper.style.top = `${subDropdownRect.top}px`;
      dropdownWrapper.style.height = `${subDropdownRect.height}px`;

      currentDropdown.style.position = 'static';
      if (isVerticalMenu(settings)) {
        currentDropdown.style.maxHeight = '100%';
      } else {
        currentDropdown.style.maxHeight = `${maxHeightCalculated}px`;
      }

      if (parentMenuItem.classList.contains('gm-has-featured-img')) {
        const image = parentMenuItem.querySelector('.attachment-menu-thumb');
        const imagePosition = getCoords(parentMenuItem);

        image.style.top = `${imagePosition.top}px`;
      }

      activatePerfectScrollbar(currentDropdown);

      currentDropdown.addEventListener('transitionend', handleTransitionEnd);

      return;
    }

    // First dropdown level --------------------------------------------------------------
    let firstDropdownRect = getFirstDropdownRect(parentMenuItem, settings);

    dropdownWrapper.style.top = `${firstDropdownRect.top}px`;
    dropdownWrapper.style.width = `${firstDropdownRect.width}px`;

    currentDropdown.style.position = 'static';
    if (isVerticalMenu(settings)) {
      currentDropdown.style.maxHeight = '100%';
    } else {
      currentDropdown.style.maxHeight = `${maxHeightCalculated}px`;
    }

    activatePerfectScrollbar(currentDropdown);

    currentDropdown.addEventListener('transitionend', handleTransitionEnd);
  }

  function handleTransitionEnd (event) {
    if (event.propertyName !== 'transform') {
      return;
    }

    updateDropdownStyles(this);

    let parentMenuItem = this.closest('.gm-dropdown');

    if (parentMenuItem && parentMenuItem.classList.contains('gm-open')) {
      activatePerfectScrollbar(this);
    }
  }

  function mobileTransitionStart (event) {
    if (event.propertyName !== 'transform') {
      return;
    }

    let drawer = document.querySelector('.gm-navigation-drawer--mobile');
    if (drawer) {
      drawer.classList.add('gm-transition-work');

      if (settings.mobileSubmenuStyle && 'slider' === settings.mobileSubmenuStyle) {

        let isOpened = drawer.querySelector('.gm-menu-item.gm-open');
        let menuItems = drawer.querySelectorAll('.gm-menu-item');
        let isDrawerOpen = drawer.classList.contains('gm-navigation-drawer--open');

        if (isOpened) {
          if (menuItems) {
            menuItems.forEach((item) => {

              //item.style.display = 'none';
              item.classList.add('gm-item-hidden');

              let isOpenedChild = item.querySelector('.gm-menu-item.gm-open');
              let currentMenuWrapper = item.closest('.gm-dropdown-menu-wrapper');
              let parentMenuItem = currentMenuWrapper ? currentMenuWrapper.closest('.gm-dropdown') : false;
              let isParentMenuOpen = parentMenuItem ? parentMenuItem.classList.contains('gm-open') : false;
              let isHasDeeper = parentMenuItem ? parentMenuItem.querySelector('.gm-dropdown.gm-open') : false;

              let isDisplay = false;

              if (!isDrawerOpen) {
                isDisplay = true;
              }

              if (isOpenedChild) {
                isDisplay = true;
              }

              if (isParentMenuOpen && !isHasDeeper) {
                isDisplay = true;
              }

              if (item.classList.contains('gm-open')) {
                isDisplay = true;
              }

              if (isDisplay) {
                //item.style.display = null;
                item.classList.remove('gm-item-hidden');
              }

            });
          }
        } else {
          menuItems.forEach((item) => {
            //item.style.display = null;
            item.classList.remove('gm-item-hidden');
          });
        }

      }

    }
  }

  function mobileTransitionEnd (event) {
    if (event.propertyName !== 'transform') {
      return;
    }

    let drawer = document.querySelector('.gm-navigation-drawer--mobile');
    if (drawer) {
      drawer.classList.remove('gm-transition-work');
    }
  }

  function makeHiddenVisible(event) {
    if (event.propertyName !== 'transform') {
      return;
    }

    let drawer = document.querySelector('.gm-navigation-drawer--mobile');
    if (drawer) {
      let menuItems = drawer.querySelectorAll('.gm-menu-item');

      if (menuItems) {
        menuItems.forEach((item) => {
          item.classList.remove('gm-item-hidden');
        });
      }
    }
  }

  function updateDropdownStyles (elem) {
    let parentMenuItem = elem.closest('.gm-dropdown');

    if (parentMenuItem && parentMenuItem.classList.contains('gm-open')) {

      let maxHeightCalculated = getDropdownMaxHeight(elem, true);

      elem.style.position = 'static';
      elem.style.transform = 'none';
      if (isVerticalMenu(settings)) {
        elem.style.maxHeight = '100%';
      } else {
        elem.style.maxHeight = `${maxHeightCalculated}px`;
      }

      if (elem.classList.contains('ps')) {
        let psId = elem.getAttribute('data-ps-id');
        if (psId && scrollbars && scrollbars[psId]) {
          scrollbars[psId].update();
        }
      }

    } else {
      elem.style.transform = null;
    }

  }

  function handleScrollbarMouseLeave() {
    let parentMenuItem = this.closest('.gm-dropdown');

    if (!parentMenuItem) {
      return;
    }

    let currentDropdown = parentMenuItem.querySelector('.gm-dropdown-menu');

    if (!currentDropdown) {
      return;
    }

    currentDropdown.style.transform = null;
  }

  function activatePerfectScrollbar (elem) {

    if (!elem) {
      return;
    }

    let isHandled = elem.classList.contains('ps');

    // Return if Perfect Scrollbar already arsing for elem.
    if (isHandled) {
      return;
    }

    // Preventing the calculation of the height of the current dropdown for all sub-dropdowns
    let childDropdowns = elem.querySelectorAll('.gm-dropdown-submenu');
    if (childDropdowns) {
      childDropdowns.forEach((dropdown) => {
        dropdown.style.position = 'static';
      });
    }

    let scrollWheelSpeed = 0.6;

    if (settings.scrollbarEnableWheelSpeed && settings.scrollbarEnableWheelSpeed > 9) {
      scrollWheelSpeed = settings.scrollbarEnableWheelSpeed / 100;
    }

    // Init Perfect Scrollbar for elem.
    const ps = new PerfectScrollbar(elem, {
      suppressScrollX: true,
      wheelPropagation: false,
      swipeEasing: false,
      wheelSpeed: scrollWheelSpeed
    });

    // Save the index of the scrollbar object for further manipulation.
    elem.setAttribute('data-ps-id', scrollbars.length);

    // Save scrollbar object to array.
    scrollbars.push(ps);
  }

  function activatePerfectScrollbarMobile (elem) {

    if (!elem) {
      return;
    }

    let isHandled = elem.classList.contains('ps');

    // Return if Perfect Scrollbar already arsing for elem.
    if (isHandled) {
      return;
    }

    // Init Perfect Scrollbar for elem.
    const ps = new PerfectScrollbar(elem, {
      suppressScrollX: true,
      wheelPropagation: false,
      swipeEasing: true,
      wheelSpeed: 1
    });

    // Save the index of the scrollbar object for further manipulation.
    elem.setAttribute('data-ps-id', scrollbars.length);

    // Save scrollbar object to array.
    scrollbars.push(ps);
  }


  function enableMobileScrollbar() {
    let mobileWrapper = document.querySelector('.gm-navigation-drawer--mobile .gm-grid-container');
    if (mobileWrapper) {

      activatePerfectScrollbarMobile(mobileWrapper);

      let dropdownMenuMobile = document.querySelectorAll('.gm-navigation-drawer--mobile .gm-dropdown > .gm-dropdown-menu-wrapper');
      let drawerMenuMobile = document.querySelector('.gm-navigation-drawer--mobile');

      if (drawerMenuMobile) {
        drawerMenuMobile.addEventListener('transitionstart', makeHiddenVisible);
      }

      if (dropdownMenuMobile) {
        dropdownMenuMobile.forEach((dropdown) => {
          dropdown.addEventListener('transitionstart', mobileTransitionStart);
          dropdown.addEventListener('transitionend', mobileTransitionEnd);
        });
      }

      mobileWrapper.addEventListener('click', function (event) {
        if (!event.target.closest('.gm-caret')) {
          return;
        }

        let scrollWrapper = event.target.closest('.ps');
        if (scrollWrapper) {
          let psId = scrollWrapper.getAttribute('data-ps-id');
          if (psId && scrollbars && scrollbars[psId]) {
            setTimeout(() => {

              scrollbars[psId].update();

            }, 750);
          }
        }
      });

    }
  }

  function enableScrollbar () {
    if (isMobile(settings.mobileWidth)) {
      return;
    }

    dropdownMenuLinks.forEach((link) => {
      link.addEventListener('mouseenter', handleScrollbarMouseEnter);
      link.addEventListener('mouseleave', handleScrollbarMouseLeave);
    });
  }

  function handleResize () {
    if (window.gmIsResizeOnlyHorisontal) {
      return;
    }

    if (!isMobile(settings.mobileWidth) && settings.scrollbarEnable) {
      enableScrollbar();
    }
  }

  // Enable for desktop.
  if (settings.scrollbarEnable) {
    enableScrollbar();
  }

  // Enable for mobile.
  if (settings.scrollbarEnableMobile) {
    enableMobileScrollbar();
  }

  window.addEventListener('resize', _.throttle(handleResize, 100));
}
