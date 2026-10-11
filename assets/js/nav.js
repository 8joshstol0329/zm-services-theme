// Sitewide hamburger nav toggle. functions.php loads this on every page.
document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.querySelector('.hamburger');
  const navRight = document.querySelector('.nav-right');
  const backdrop = document.querySelector('.nav-backdrop');

  if (!hamburger || !navRight) {
    // Guard clause: if either element is missing on a given page,
    // fail quietly instead of throwing and breaking the rest of the page's JS.
    return;
  }

  function openMenu() {
    hamburger.classList.add('active');
    navRight.classList.add('active');
    if (backdrop) backdrop.classList.add('active');
    hamburger.setAttribute('aria-expanded', 'true');
    document.body.classList.add('nav-open');
  }

  function closeMenu() {
    hamburger.classList.remove('active');
    navRight.classList.remove('active');
    if (backdrop) backdrop.classList.remove('active');
    hamburger.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('nav-open');
  }

  hamburger.addEventListener('click', () => {
    const isOpen = navRight.classList.contains('active');
    isOpen ? closeMenu() : openMenu();
  });

  // Tapping outside the menu (on the dimmed backdrop) closes it
  if (backdrop) {
    backdrop.addEventListener('click', closeMenu);
  }

  // Tapping a nav link closes the menu automatically
  navRight.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeMenu);
  });

  // The "current page" highlight used to be worked out here by comparing file
  // names (about.html, gallery.html). WordPress pages don't have file names, so
  // header.php now adds the "current" class with PHP instead: see zm_current()
  // in functions.php.
});
