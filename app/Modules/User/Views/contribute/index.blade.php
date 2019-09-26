@extends('layout')
@section('title','E+ Đóng Góp')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/contribute.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/contribute.css')!!}
@stop
@section('left-tab')
	<div class="col-lg-3 col-md-12 col-lg-push-9 no-padding">
		<div id="sectionA" class="tab-pane fade active in">
            <div class="left-header" data-target=".question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="90%">
                                <h5>Danh mục quảng cáo của bạn</h5>
                            </td>
                            <td class="collapse-icon" width="10%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="collapse in question close-when-small">
                <div class="col-xs-12">
	                <div class="width-50 inline-block float-left">
	                    <div class="form-group">
	                        <div class="input-group ">
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="1" checked="">Khóa tài khoản (1)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="2">Xóa bình luận (2)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="3">Chỉnh sửa (3)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="4">Ghim bài viết (4)</label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="width-50 inline-block">
	                    <div class="form-group">
	                        <div class="input-group ">
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="5">Thêm mới (5)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="6">Cập nhật (6)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="7" checked="">Xóa (7)</label>
	                            </div>
	                            <div class="checkbox">
	                              <label><input type="checkbox" value="8" checked="">In Dữ Liệu (8)</label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>
                <button class="btn btn-sm btn-primary answer-btn " type="button">Cài Đặt</button>
            </div>
            <div class="left-header" data-target=".new-question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Danh sách quảng cáo đã xem</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="watched-ad">
                <div id="example2" class="slider-pro right-slide">
					<div class="sp-slides">
						<div class="sp-slide">
							<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image1_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image1_large.jpg"/>
							</a><h5 class='brain-title'>League of legends League of legends</h5>
							<p class='brain-detail'>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</div>

				        <div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image2_large.jpg">
				        		<img class="sp-image" src="../src/css/images/blank.gif" 
				        			data-src="http://bqworks.com/slider-pro/images2/image2_medium.jpg" 
				        			data-retina="http://bqworks.com/slider-pro/images2/image2_large.jpg"/>
				        	</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image3_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image3_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image4_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image4_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image4_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image5_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image5_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image5_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image6_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image6_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image6_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image7_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image7_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image7_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image8_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image8_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image8_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
						</div>



						<div class="sp-slide">
							<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image9_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image9_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image10_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image10_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image10_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
						</div>

						<div class="sp-slide">
							<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image11_large.jpg">
								<img class="sp-image" src="../src/css/images/blank.gif" 
									data-src="http://bqworks.com/slider-pro/images2/image11_medium.jpg" 
									data-retina="http://bqworks.com/slider-pro/images2/image11_large.jpg"/>
							</a><h5 class='brain-title'>League of legends</h5>
							<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
						</div>
					</div>
			    </div>
            </div>
        </div>
	</div>
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding col-lg-pull-3 change-content">
	<div id="example1" class="slider-pro">
		<div class="sp-slides">
			<div class="sp-slide">
                    <a class="sp-video sp-lightbox" data-type="iframe" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
                        <img src="http://bqworks.com/slider-pro/images/nasa_video_poster.jpg" width="100%" height="100%"/>
                    </a>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

	        <div class="sp-slide">
	        	<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images/image1_large.jpg">
					<img src="http://bqworks.com/slider-pro/images/image1_large.jpg" width="100%" height="100%" />
				</a>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image3_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image3_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image4_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image4_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image5_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image5_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image6_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image6_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image7_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image7_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image8_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image8_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image9_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image9_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>

			<div class="sp-slide">
				<img class="sp-image" src="../src/css/images/blank.gif"
					data-src="http://bqworks.com/slider-pro/images/image10_medium.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image10_large.jpg"/>

				<p class="sp-layer sp-black sp-padding" 
					data-position="topLeft"
					data-show-transition="left" data-hide-transition="right">
					Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
				</p>
			</div>
		</div>

		<div class="sp-thumbnails">
			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image1_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Lorem ipsum</div>
					<div class="sp-thumbnail-description">Dolor sit amet, consectetur adipiscing</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image2_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Do eiusmod</div>
					<div class="sp-thumbnail-description">Tempor incididunt ut labore et dolore magna</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image3_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Ut enim</div>
					<div class="sp-thumbnail-description">Ad minim veniam, quis nostrud exercitation</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image4_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Ullamco oris</div>
					<div class="sp-thumbnail-description">Nisi ut aliquip ex ea commodo consequat</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image5_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Duis aute</div>
					<div class="sp-thumbnail-description">Irure dolor in reprehenderit</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image6_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Esse cillum</div>
					<div class="sp-thumbnail-description">Dolore eu fugiat nulla pariatur excepteur</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image7_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Sint occaecat</div>
					<div class="sp-thumbnail-description">Cupidatat non proident, sunt in culpa</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image8_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Deserunt</div>
					<div class="sp-thumbnail-description">Mollit anim id est laborum sed ut</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image9_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Unde omnis</div>
					<div class="sp-thumbnail-description">Iste natus error sit voluptatem</div>
				</div>
			</div>

			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
					<img class="sp-thumbnail-image" src="http://bqworks.com/slider-pro/images/image10_thumbnail.jpg"/>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title">Laudantium</div>
					<div class="sp-thumbnail-description">Totam rem aperiam, eaque ipsa quae ab illo</div>
				</div>
			</div>
		</div>
    </div>
    <div class=" col-xs-12 no-padding right-header no-fixed">
        <h5>
            <i class="fa fa-hand-o-right">
            </i>
            Trò Chơi
        </h5>
    </div>
    <div id="example2" class="slider-pro sub-block">
		<div class="sp-slides">
			<div class="sp-slide">
				<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image1_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image1_large.jpg"/>
				</a><h5 class='brain-title'>League of legends League of legends</h5>
				<p class='brain-detail'>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			</div>

	        <div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image2_large.jpg">
	        		<img class="sp-image" src="../src/css/images/blank.gif" 
	        			data-src="http://bqworks.com/slider-pro/images2/image2_medium.jpg" 
	        			data-retina="http://bqworks.com/slider-pro/images2/image2_large.jpg"/>
	        	</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image3_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image3_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image4_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image4_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image4_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image5_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image5_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image5_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image6_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image6_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image6_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image7_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image7_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image7_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image8_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image8_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image8_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
			</div>



			<div class="sp-slide">
				<a class="sp-lightbox sp-video" rel="gallery" href="http://www.youtube.com/embed/WAZ5SmJd1To?autoplay=1">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image9_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image9_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image10_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image10_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image10_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image11_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image11_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image11_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
			</div>
		</div>
    </div>
	<div class=" col-xs-12 no-padding right-header no-fixed">
        <h5>
            <i class="fa fa-hand-o-right">
            </i>
            Trò Chơi
        </h5>
    </div>
    <div id="example3" class="slider-pro sub-block">
		<div class="sp-slides">
			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image1_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image1_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image1_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			</div>

	        <div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image2_large.jpg">
	        		<img class="sp-image" src="../src/css/images/blank.gif" 
	        			data-src="http://bqworks.com/slider-pro/images2/image2_medium.jpg" 
	        			data-retina="http://bqworks.com/slider-pro/images2/image2_large.jpg"/>
	        	</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image3_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image3_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image3_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image4_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image4_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image4_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image5_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image5_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image5_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image6_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image6_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image6_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image7_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image7_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image7_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image8_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image8_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image8_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
			</div>



			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image9_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image9_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image9_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image10_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image10_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image10_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
			</div>

			<div class="sp-slide">
				<a class="sp-lightbox" rel="gallery" href="http://bqworks.com/slider-pro/images2/image11_large.jpg">
					<img class="sp-image" src="../src/css/images/blank.gif" 
						data-src="http://bqworks.com/slider-pro/images2/image11_medium.jpg" 
						data-retina="http://bqworks.com/slider-pro/images2/image11_large.jpg"/>
				</a><h5 class='brain-title'>League of legends</h5>
				<p class='brain-detail'>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.</p>
			</div>
		</div>
    </div>
</div>
@stop
