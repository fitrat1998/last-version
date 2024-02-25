$(document).ready(() => {
  /* Hamburger */
  $("#humburger").click(() => {
    $("#sider").toggleClass("show");
    $(".sider--button").toggleClass("hidden");
    $("main").toggleClass("siderShow");
  });

  $(".onPrevAction").click((e) => {
    e.preventDefault();
    window.history.back();
  });

  /* Tooltip */
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
