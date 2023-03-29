function initAlerts() {
  var alerts = document.getElementsByClassName('alert');
  for (var i = 0; i < alerts.length; i++) {
    alerts[i].querySelector('.alert__close').addEventListener('click', closeAlert);
  }
}
function closeAlert(e) {
  var alert = e.target.closest('.alert');
  if (alert) {
    alert.classList.add('close');
    setTimeout(function() {alert.parentNode.removeChild(alert);}, 250);
  }
}
initAlerts();