$(function(){
 $('.dropdown-trigger').dropdown({
   inDuration: 1000,
     outDuration: 2000,
     constrainWidth: false,
     hover: true,
     coverTrigger: false,
     belowOrigin: true,
     alignment: 'left',
     stopPropagation: true
 });
});

$(document).ready(function(){
  $('.sidenav').sidenav();
});
