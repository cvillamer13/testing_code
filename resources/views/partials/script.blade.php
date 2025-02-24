<!--**********************************
        Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/select2-init.js') }}"></script>

<!-- for pdf -->

<script src="{{ asset('js/pdf/html2canvas.min.js') }}"></script>

<!-- Datatable -->
{{-- <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script> --}}
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/metismenu/3.0.7/metisMenu.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>

<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>

<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/deznav-init.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>
$(".mode").on("click", function () {
    $(".mode").toggleClass("dark");
    $("body").toggleClass("dark-only");
    var color = $(this).attr("data-theme-version");
    $("body").attr('data-theme-version', $(this).attr('data-id'));
    
    setCookie('version', $(this).attr('data-id'));
    var href = document.location.href;
    var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
    window.location.href = lastPathSegment;
  });

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

if(getCookie('version') == 'light')
{
$(".mode").attr('data-id', "dark");
$(".mode").removeClass("dark");
$("body").removeClass("dark-only");
$('.mode').html('<svg class="lighticon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g><g><path fill-rule="evenodd" clip-rule="evenodd" d="M18.1377 13.7902C19.2217 14.8742 16.3477 21.0542 10.6517 21.0542C6.39771 21.0542 2.94971 17.6062 2.94971 13.3532C2.94971 8.05317 8.17871 4.66317 9.67771 6.16217C10.5407 7.02517 9.56871 11.0862 11.1167 12.6352C12.6647 14.1842 17.0537 12.7062 18.1377 13.7902Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>');

}
else 
{
$(".mode").attr('data-id', "light");
$(".mode").addClass("dark");
$("body").addClass("dark-only");
$('.mode').html('<svg class="darkicon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12Z"></path><path d="M18.3117 5.68834L18.4286 5.57143M5.57144 18.4286L5.68832 18.3117M12 3.07394V3M12 21V20.9261M3.07394 12H3M21 12H20.9261M5.68831 5.68834L5.5714 5.57143M18.4286 18.4286L18.3117 18.3117" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
}

$('.layout_style').on('click',function()
{

    var type = $(this).attr('data-val');
    html.attr('dir', type);
        html.attr('class', '');
        html.addClass(type);
        body.attr('direction', type);
        setCookie('direction', type);
});


function pages_checker(id){
    $.ajax({
        type: "POST",
        url: "/permissions/check",
        data: {
            "_token": "{{ csrf_token() }}",
            page_id: id
        },
        success: function (response) {
            if(response.status == "success"){
                let protocol = window.location.protocol;
                if(response.permission == null){
                    toastr.error("Sorry you dont have right on this module.");
                    window.location.href = "./";
                }
                if(response.permission.isView){
                    window.location.href = response.page.URL;
                }else{
                    toastr.error("Sorry you dont have right on this module.");
                    window.location.href = "./";
                }
            }
            // console.log(response)
        },
        error: function (error){

        }
    });
}

</script>