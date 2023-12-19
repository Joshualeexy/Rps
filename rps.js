setInterval(()=>{
  let gameid = $('#gameid').val();
$('.currPlayer').load('loadcurrgameturns.php', {
  gameid: gameid
});
},1000);

setInterval(()=>{
$('#loadusersdiv').load('loadusers.php');
},1000);

$('#close-alert').click(()=> {
  $(".alert-box").removeClass('show');
})



