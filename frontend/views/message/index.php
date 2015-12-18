<script>
$.ajax({
    //url: "https://api.github.com/search/repositories",
    url: "https://sms.yunpian.com/v1/sms/send.json",
    dataType: 'json',
    delay: 250,
    data:{'apikey': '09b97cd3fa65c19db6698ef593844e3d', 'mobile': '15921270388', 'text': '【上海斯程】您的验证码是1234'},
    cache: true
  })
</script>