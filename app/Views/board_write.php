    <form method="post" action="<?= site_url('/write_save') ?>" enctype="multipart/form-data">
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">제목</label>
            <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요." value="">
        </div>
        <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">내용</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3"></textarea>
        </div>
        <br />
        <button type="submit" class="btn btn-primary">등록</button>
    </form>