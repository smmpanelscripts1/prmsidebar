<link rel="stylesheet" href="/assets/extensions/prmsidebar/dashboard.style.css?v=1.0.3">
<script>
(function () {
  var lastPath = '';
  var isMobile = function () {
    return window.matchMedia('(max-width: 900px)').matches;
  };

  try {
    if (localStorage.getItem('prm-sb-collapsed') === '1') {
      document.body.classList.add('prm-sb-collapsed');
    }
  } catch (e) {}

  function ensureChrome() {
    if (!document.getElementById('prm-sb-toggle')) {
      var btn = document.createElement('button');
      btn.id = 'prm-sb-toggle';
      btn.type = 'button';
      btn.setAttribute('aria-label', 'Toggle navigation');
      btn.innerHTML = '<span></span><span></span><span></span>';
      btn.addEventListener('click', function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        if (isMobile()) {
          document.body.classList.toggle('prm-sb-open');
        } else {
          document.body.classList.toggle('prm-sb-collapsed');
          try {
            localStorage.setItem(
              'prm-sb-collapsed',
              document.body.classList.contains('prm-sb-collapsed') ? '1' : '0'
            );
          } catch (err) {}
        }
      });
      document.body.appendChild(btn);
    }
    if (!document.getElementById('prm-sb-backdrop')) {
      var mask = document.createElement('div');
      mask.id = 'prm-sb-backdrop';
      mask.addEventListener('click', function () {
        document.body.classList.remove('prm-sb-open');
      });
      document.body.appendChild(mask);
    }
  }

  function subLabel() {
    var path = location.pathname || '';
    if (path.indexOf('/server/') === 0) return 'SERVER';
    if (path.indexOf('/account') === 0) return 'ACCOUNT';
    return 'PAGES';
  }

  function tick() {
    var bar = document.getElementById('NavigationBar');
    if (!bar) return;
    ensureChrome();
    document.body.classList.add('prm-sb');

    var nav = document.querySelector('#NavigationBar #logo + *');
    var sub = document.getElementById('SubNavigation');
    document.body.classList.toggle('prm-sb-sub', !!sub);

    if (nav) {
      document.documentElement.style.setProperty('--prm-nav-block', nav.offsetHeight + 'px');
    }

    var bars = document.querySelectorAll('div');
    for (var i = 0; i < bars.length; i++) {
      if (bars[i].style && bars[i].style.height === '2px') {
        bars[i].style.top = '50px';
        bars[i].style.left = '0px';
        bars[i].style.width = '100%';
        bars[i].style.zIndex = '130';
        bars[i].style.position = 'fixed';
        break;
      }
    }

    if (sub) {
      var box = sub.querySelector(':scope > div');
      if (box) box.setAttribute('data-prm-label', subLabel());
    }

    var path = location.pathname;
    if (path !== lastPath) {
      lastPath = path;
      document.body.classList.remove('prm-sb-open');
    }
  }

  setInterval(tick, 400);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', tick);
  } else {
    tick();
  }
})();
</script>
