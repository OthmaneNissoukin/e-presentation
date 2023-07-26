function ajax_operation() {
  let xhr = new XMLHttpRequest();

  xhr.open("POST", "index.php?action=register");
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(
    `trainee_1=${trainee_1_name}&trainee_2=${trainee_2_name}&trainee_3=${trainee_3_name}&group=${group_code}&presentation_date=&presentation_time=`
  );
}
