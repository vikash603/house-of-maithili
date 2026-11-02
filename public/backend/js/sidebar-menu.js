$.sidebarMenu = function (menu) {
  var animationSpeed = 300,
    subMenuSelector = '.sidebar-submenu';
  $(menu).on('click', 'li a', function (e) {
    var $this = $(this);
    var checkElement = $this.next();
    var wasSubmenuVisible = checkElement.is(subMenuSelector) && checkElement.is(':visible');
    if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
      checkElement.slideUp(animationSpeed, function () {
        checkElement.removeClass('menu-open');
      });
      checkElement.parent("li").removeClass("active");
    } else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
      var parent = $this.parents('ul').first();
      var ul = parent.find('ul:visible').slideUp(animationSpeed);
      ul.removeClass('menu-open');
      var parent_li = $this.parent("li");
      checkElement.slideDown(animationSpeed, function () {
        checkElement.addClass('menu-open');
        parent.find('li.active').removeClass('active');
        parent_li.addClass('active');
      });
    }
    if (checkElement.is(subMenuSelector)) {
      var $parent = $this.parent('li');
      $this.attr('aria-expanded', wasSubmenuVisible ? 'false' : 'true');
      if ($parent.children(subMenuSelector).length) {
        if (wasSubmenuVisible) {
          sessionStorage.removeItem('adminSidebarOpenMenu');
        } else {
          sessionStorage.setItem('adminSidebarOpenMenu', $parent.index());
        }
      }
      e.preventDefault();
    }
  });
}
$.sidebarMenu($('.sidebar-menu'))
$nav = $('.page-sidebar');
$header = $('.page-main-header');
$toggle_nav_top = $('#sidebar-toggle');
$toggle_nav_top.click(function () {
  $this = $(this);
  $nav = $('.page-sidebar');
  $nav.toggleClass('open');
  $header.toggleClass('open');

});
$body_part_side = $('.body-part');
$body_part_side.click(function () {
  $nav.addClass('open');
  $header.addClass('open');
});

$(".sidebar-back").click(function () {
  $(".page-sidebar").addClass("open");
});

//    responsive sidebar
var $window = $(window);
var widthwindow = $window.width();
(function ($) {
  "use strict";
  if (widthwindow <= 991) {
    $toggle_nav_top.addClass("open");
    $nav.addClass("open");
  }
})(jQuery);
$(window).resize(function () {
  var widthwindaw = $window.width();
  if (widthwindaw + 17 <= 991) {
    $toggle_nav_top.addClass("open");
    $nav.addClass("open");
  } else {
    $toggle_nav_top.removeClass("open");
    $nav.removeClass("open");
  }
});

// Match routes, including nested links, without false partial URL matches.
var currentUrl = new URL(window.location.href);
var currentPath = currentUrl.pathname.replace(/\/$/, '') || '/';
$('.sidebar-menu a[href]').each(function () {
  var rawHref = $(this).attr('href');
  if (!rawHref || rawHref === '#' || rawHref.indexOf('javascript:') === 0) return;

  var target;
  try { target = new URL(rawHref, window.location.origin); } catch (error) { return; }
  var targetPath = target.pathname.replace(/\/$/, '') || '/';
  var pathMatches = currentPath === targetPath || (targetPath !== '/' && targetPath !== '/admin/orders' && currentPath.indexOf(targetPath + '/') === 0);
  if (!pathMatches) return;
  if (targetPath === '/admin/orders/list' && target.search === '' && (currentUrl.searchParams.has('status') || currentUrl.searchParams.has('refund_status'))) return;

  var queryMatches = true;
  target.searchParams.forEach(function (value, key) {
    if (currentUrl.searchParams.get(key) !== value) queryMatches = false;
  });
  if (!queryMatches) return;

  $(this).addClass('active').closest('li').addClass('active');
  $(this).parents('li').addClass('active').children('.sidebar-header').addClass('active').attr('aria-expanded', 'true');
});

// Re-open the current or last expanded submenu after navigation.
var $activeSubmenu = $('.sidebar-menu > li.active > .sidebar-submenu').first();
if ($activeSubmenu.length) {
  $activeSubmenu.addClass('menu-open').show();
} else {
  var rememberedIndex = sessionStorage.getItem('adminSidebarOpenMenu');
  if (rememberedIndex !== null) {
    var $remembered = $('.sidebar-menu > li').eq(Number(rememberedIndex));
    var $rememberedSubmenu = $remembered.children('.sidebar-submenu');
    if ($rememberedSubmenu.length) {
      $remembered.addClass('active').children('.sidebar-header').attr('aria-expanded', 'true');
      $rememberedSubmenu.addClass('menu-open').show();
    }
  }
}
