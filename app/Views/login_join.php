<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script  src="http://code.jquery.com/jquery-latest.min.js"></script>
    <title></title>
  </head>
  <body>
  <div class="col-md-8" style="margin:auto;padding:20px;">
  <div class="wrap">
  <!-- Header -->

  <form class="row g-3 needs-validation" action="<?php echo base_url(); ?>/loginjoinok" method="post">
       
        <div class="col-12">
            <label for="validationCustom02" class="form-label">아이디</label>
            <input type="text" class="form-control" id="userid" name="userid" placeholder="" required>
        </div>
        <div class="col-12">
            <label for="validationCustom02" class="form-label">이름</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="" required>
        </div>
        <div class="col-12">
            <label for="validationCustom02" class="form-label">비밀번호</label>
            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="" required>
        </div>
        <div class="col-12">
            <label for="validationCustom02" class="form-label">이메일</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="" required>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">회원가입</button>
        </div>
    </form>
  
  <!-- Footer -->
  </div>
  </div>

</body>
</html>    