function ajax_operation() {
  let xhr = new XMLHttpRequest();

  xhr.open("POST", "index.php?action=save_team_updates");
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(
    `trainee_1=${trainee_1_name}&trainee_2=${trainee_2_name}&trainee_3=${trainee_3_name}&
    group=${group_code}&presentation_date=${presentation_date_value}&presentation_time=${presentation_time_value}`
  );
}
