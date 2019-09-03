$(document).ready(function() {

    // Immage upload
    $('#customFile').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#customFile')[0].files[0].name;
        $(this).prev('label').text(file);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Post like
    $('.infinite-scroll').on('click', '.panel-like', function(){    
        var id = $(this).data('id');
        var c = $('#'+this.id+'-bs3').html();
        var cObjId = this.id;
        var cObj = $(this);

        $.ajax({
            type:'POST',
            url:'/ajaxRequestLike',
            data:{id:id},
            success:function(data){
                if(jQuery.isEmptyObject(data.sukses[0].s.attached)){
                    $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                    $(cObj).removeClass("like-post");
                }else{
                    OnSuccess(data.sukses[1].id);
                    $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                    $(cObj).addClass("like-post");
                }
            },
            error: function(request,  error , status) {
                Session('Error', 'Error'); 
            }
        });
    }); 
    
    function OnSuccess(data) {
        var id = data;

        $.ajax({
            type:'POST',
            url:'/ajaxRequestIns',
            data:{id:id},
            success:function(){
                
            },
        });
    }

    // Pic like
    $('.infinite-scroll').on('click', '.panel-love', function(){    
        var id = $(this).data('id');
        var c = $('#'+this.id+'-bs3').html();
        var cObjId = this.id;
        var cObj = $(this);

        $.ajax({
            type:'POST',
            url:'/ajaxRequestLove',
            data:{id:id},
            success:function(data){
                if(jQuery.isEmptyObject(data.love[0].s.attached)){
                    $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                    $(cObj).removeClass("like-post");
                }else{
                    OnSukses(data.love[1].id);
                    $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                    $(cObj).addClass("like-post");
                }
            },
            error: function(request,  error , status) {
                Session('Error', 'Error'); 
            }
        });
    }); 

    function OnSukses(data) {
        var id = data;

        $.ajax({
            type:'POST',
            url:'/ajaxRequestInst',
            data:{id:id},
            success:function(){
                
            },
        });
    }

    // Follow
    $('.action-follow').click(function(){    
        var user_id = $(this).data('id');
        var cObj = $(this);
        var c = $("#follower-counter").text();


        $.ajax({
           type:'POST',
           url:'/ajaxRequest',
           data:{user_id:user_id},
           success:function(data){
              if(data.unfollow){
                cObj.find("strong").text("Follow");
                $(cObj).removeClass("btn-success");
                $(cObj).addClass("btn-primary");
                // alert("c: " + c)
                $("#follower-counter").text(parseInt(c)-1);
              }else{
                // OnFollow(user_id);
                cObj.find("strong").text("Followed");
                $(cObj).removeClass("btn-primary");
                $(cObj).addClass("btn-success");
                // alert("c: " + c )
                $("#follower-counter").text(parseInt(c)+1);
              }
           }
        });
    });   

    // function OnFollow(data) {
    //     var id = data;

    //     $.ajax({
    //         type:'POST',
    //         url:'/ajaxNotif',
    //         data:{id:id},
    //         success:function(data){console.log(data.success)
    //             alert ('success');
    //         },
    //     });
    // }

    // Follow from Home sidebar
    $('.sidebar-follower').click(function(){    
        var user_id = $(this).data('id');
        var cObj = $(this);
        var ctr = $("#side-counter-"+user_id).text();


        $.ajax({
           type:'POST',
           url:'/ajaxRequest',
           data:{user_id:user_id},
           success:function(data){
              if(data.unfollow){
                cObj.text("Follow");
                // console.log("c: " + ctr)
                $("#side-counter-"+user_id).text(parseInt(ctr)-1);
              }else{
                cObj.text("Following");
                // console.log("c: " + ctr)
                $("#side-counter-"+user_id).text(parseInt(ctr)+1);
              }
           }
        });
    });   

    $('.infinite-scroll').on("click", '.panel-comment', function(e) {
        e.preventDefault();
        var getpID =  $(this).data('id');

        if($("#show-"+getpID).hasClass('d-none')){
            $("#show-"+getpID).removeClass('d-none');
            $("#input-"+getpID).focus();
        }else{
            $("#show-"+getpID).addClass('d-none');
        }
    });

    $('.infinite-scroll').on("click",'.panel-image', function(e) {
        e.preventDefault();
        var getpID =  $(this).data('id');

        if($("#show-image-"+getpID).hasClass('d-none')){console.log(getpID)
            $("#show-image-"+getpID).removeClass('d-none');
            $("#input-"+getpID).focus();
        }else{
            $("#show-image-"+getpID).addClass('d-none');
        }
    });

    $(document).on('change', $("#imgupload"), function(){
        uploadFile();
    });

    function uploadFile(){
        var file_data = $('#imgupload').prop('files')[0];
        var formData = new FormData();
        formData.append('file', file_data);

        $.ajax({
            type: "post",
            url: "/upload",
            dataType: 'json',
            mimeType: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        console.log(percentComplete);
                        $('#status').html('<b> Uploading -> ' + (Math.round(percentComplete * 100)) + '% </b>');
                    }
                }, false);
                return xhr;
            },
            success: function(data){
                if(data.success){
                    $('#status').hide();
                    $('#background-image').attr('src', data.success);
                }else{
                    alert(data.error);
                }
            },
            error: function(){
                alert("Something wrong on our server!")
            }
        });
    }

    $('ul.pagination').hide();
    $("#backtoTop").hide();
    $("#endpage").hide();

    $(window).scroll(fetchPosts);
 
    function fetchPosts() {
        var page = $('.infinite-scroll').data('next-page');

        if(page != '') {

            if(page != null) {
                clearTimeout( $.data( this, "scrollCheck" ) );
    
                $.data( this, "scrollCheck", setTimeout(function() {
                    var scroll_position_for_posts_load = $(window).height() + $(window).scrollTop() + 100;

                    if(scroll_position_for_posts_load >= $(document).height()) {
                        $("#loaderDiv").show();
                        $.get(page, function(data){
                            $('div.infinite-scroll').append(data.posts);
                            $('div.infinite-scroll').data('next-page', data.next_page);
                            $("#loaderDiv").hide();
                        });
                    } else {
                        $("#loaderDiv").hide();
                        $("#backtoTop").show();
                        $("#endpage").show()
                    }
                }, 350))

            } else {
                $("#loaderDiv").hide();
                $("#backtoTop").show();
                $("#endpage").show()
            }

        } else {
            $("#loaderDiv").hide();
            $("#endpage").show()
        }
    }
    
    $(document).on("click", '#loadMore', function(e) {
        e.preventDefault();
        loadmore();
    });

    function loadmore(){
        var next =  $('#load-data').data('load-more');

        if(next != '') {
            if(next != null){      
                $.get(next, function(data){
                        $('div#load-data').append(data.fav);
                        $('div.favorite').data('load-more', data.next);
                    }
                );  
            } else {
                $('#loadMore').html("No more post");
            }
        } else {
            $('#loadMore').html("No more post");
        }
 
    };

    $(function(){
        //Listen for a click on any of the dropdown items
        $("#choose a").click(function(){
            //Get the value
            var value = $(this).attr("value");console.log(value);

            if(value == 'public') {
                $('#btnGroupDrop1').html("<i class='fa fa-globe' title='public'></i>");
                $('#btnGroupDrop2').html("<i class='fa fa-globe' title='public'></i>");
            } else if(value == 'followers') {
                $('#btnGroupDrop1').html("<i class='fa fa-users' title='followers'></i>");
                $('#btnGroupDrop2').html("<i class='fa fa-users' title='followers'></i>");
            } else {
                $('#btnGroupDrop1').html("<i class='fa fa-lock' title='just me'></i>");
                $('#btnGroupDrop2').html("<i class='fa fa-lock' title='just me'></i>");
            }

            //Put the retrieved value into the hidden input
            $("input[name='post_type']").val(value);
        });
    });

    // Facbook SDK
    window.fbAsyncInit = function () {
        //FB JavaScript SDK configuration and setup
        FB.init({
            appId: '2289237824733534', //FB App ID
            cookie: true,  //enable cookies to allow the server to access the session
            xfbml: true,  //parse social plugins on this page
            version: 'v3.2' //use this graph api version 3.2
        });
    }

    $('.share-button').on('click', function (e) {
        e.preventDefault();
        var ref = $(this).attr('href');console.log(ref);
        var des = $(this).data('pos');console.log(des);
        var link = ref + '?og:description=' + des;console.log(link);

        FB.ui({
            method: 'share',
            href: ref + '?og:description=' + des
        }, function (response) {
            if (response && !response.error_message) {
                console.log('User shared the page!');
            }
            else {
                console.log('User did not share the page.');
            }
        });
    });

    // theme
    var checkbox = document.querySelector('input[name=theme]');

    checkbox.addEventListener('change', function() {
        if(this.checked) {
            trans()
            document.documentElement.setAttribute('data-theme', 'dark')
        } else {
            trans()
            document.documentElement.setAttribute('data-theme', 'light')
        }
    })

    let trans = () => {
        document.documentElement.classList.add('transition');
        window.setTimeout(() => {
            document.documentElement.classList.remove('transition')
        }, 1000)
    }

    // Submit edit pos
    // import swal from 'sweetalert';

    // $('form#editpos').on('submit', function (e) {

    //     e.preventDefault();

    //     var url = $(this).attr('action');

    //     $.ajax({
    //         type: 'post',
    //         url: url,
    //         data: $('form').serialize(),
    //         success: function (data) {
    //             console.log(data);
    //             // $('#popup').removeClass("d-none");
    //             swal("Edited!", "success");
    //             $('form#editpos').addClass("d-none");
    //         }
    //     });

    // });



    // Unused-----Unused-------Unused------Unused-----Unused
    // $(function() {
    //     $('').infinitescroll({
    //         navSelector     : ".paginate",
    //         nextSelector    : ".paginate a:last",
    //         loadingHtml: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>',
    //         padding: 0,
    //         itemSelector: 'div.infinite-scroll',
    //         path: function(index) {
    //             return "?page=" + index;
    //         }
    //     });
    // });

    // $('.corner').on('click', function(){ 
    //     $('#imgupload').trigger('click'); 

    //     // $.ajax({
    //     //     type: "post",
    //     //     url: "/upload",
    //     //     dataType: "json",
    //     //     data: $('#imgupload').serialize(),
    //     //     success: function(data){

    //     //     },
    //     //     error: function(data){
    //     //         alert("Error")
    //     //     }
    //     // });
    // });

    // $('#comment-box').on("click", function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         type: "post",
    //         url: "/comment/submit",
    //         dataType: "json",
    //         data: $('#comment-box').serialize(),
    //         success: function(data){console.log(data);
    //             // var comment = '';
    //             // $.each(data, function(key, value){
    //             //     comment += '<div class="col-sm-2 img padat">';

    //             // })
    //             fetch_comment();
    //         },
    //         error: function(data){
    //             alert("Error")
    //         }
    //     });

    // });

    // function fetch_comment() {
    //     $.ajax({
    //         type: "GET",
    //         url: "/comment",
    //         success: function(items) {
    //             $('.comment-baru').html(data.sukses);
    //         },
    //         error: function(error) {
    //             alert("Error fetching items: " + error);
    //         }
    //     });
    // }
});