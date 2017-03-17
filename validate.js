/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/

function validateUpload(kind){
  var file = document.getElementById('package').files[0];
  fileSize = file.size;
  if (fileSize > 10485760){
    alert('Your archive cannot be over 10MiB in size');
    return false;
  }
  return true;
}