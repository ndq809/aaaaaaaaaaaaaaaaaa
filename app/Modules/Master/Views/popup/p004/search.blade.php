<div class="input-group">
    <div class="col-xs-12 no-padding">
        <div class="example-header title-header">
            <span>{{isset($data)&&$data[0][0]['post_title']?$data[0][0]['post_title']:'Tiêu đề bài viết'}}</span>
        </div>
    </div>
    <div class="main-content col-xs-12 no-padding" id="noiDungNP">{!!isset($data)&&$data[0][0]['post_content']?$data[0][0]['post_content']:'Nội dung bài viết'!!}</div>
</div>