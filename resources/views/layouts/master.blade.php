<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    {{--
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <title>{{ config('app.name') }}</title>
    <!-- Plugin css for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css')}}">
</head>

<body>




    
        <div class="main-wrapper">
        <!-- partial:partials/_navbar.html -->
            @include('layouts.navbar')
        <!-- partial -->
                @include('layouts.sidebar')
            <!-- partial -->
                <div class="page-wrapper">
                    @yield('content')
                </div>

                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
     
                <!-- partial -->
            <!-- main-panel ends -->
        </div>


        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/select2/js/custom-select.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/fileupload/fileupload.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>



        <!-- Plugin js for this page -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
                    $(document).on("click", ".btn_logout", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to Logout from here!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('logout') }}',
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                history.pushState(null, null, '{{ route('login') }}');
                                window.location.href = '{{ route('login') }}';
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to logout. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
 $('.selectall').click(function() {
        if ($(this).is(':checked')) {
            $('input:checkbox').prop('checked', true);
        } else {
            $('input:checkbox').prop('checked', false);
        }
    });
    $(".add, .edit, .delete").click(function() {
        if ($(this).is(':checked')) {
            $(this).parent().parent().find('.list').prop('checked', true);
        } else {
            $(".add, .edit, .delete").parent().parent().prop('checked', false);
        }
    });

            $('#country').on('change', function () {
            var countryId = this.value;
            $('#state').html('');
            $.ajax({
                url: '{{ route('getStates') }}?country_id=' + countryId,
                type: 'get',
                success: function (res) {
                    //   console.log(res);
                    $('#state').html('<option value="">Select State</option>');
                    $.each(res, function (key, value) {
                        console.log(value.name)
                        $('#state').append('<option value="' + value
                                .id + '" >' + value.name + '</option>');
                    });
                    $('#city').html('<option value="">Select City</option>');
                }
            });
        });
          $('#state').on('change', function () {
                  var stateId = this.value;
                  $('#city').html('');
                  $.ajax({
                      url: '{{ route('getCities') }}?state_id='+stateId,
                      type: 'get',
                      success: function (res) {
                          $('#city').html('<option value="">Select City</option>');
                          $.each(res, function (key, value) {
                              $('#city').append('<option value="' + value
                                  .id + '">' + value.name + '</option>');
                          });
                      }
                  });
              });
    </script>
    <script>
  $(document).ready(function() {
    // Add new product row
    $('#addProductRow').click(function() {
        $('#productTable tbody').append(`
            <tr>
                <td><input type="text" class="form-control" name="name[]" placeholder="Product Name"></td>
                <td><input type="number" class="form-control" name="price[]" placeholder="Price"></td>
                <td><input type="number" class="form-control" name="stock[]" placeholder="Stock"></td>
                <td>
                    <select class="form-select" name="tax[]">
                        <option value="5">GST 5%</option>
                        <option value="12">GST 12%</option>
                        <option value="18">GST 18%</option>
                    </select>
                </td>
                <td><input type="number" class="form-control" name="total[]" placeholder="Total"></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">x</button></td>
            </tr>
        `);
    });

    // Remove product row
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
    });

    // Save products and append to hidden field in invoice form
    $('#saveProduct').click(function() {
        let products = [];
        $('#productTable tbody tr').each(function() {
            let product = {
                name: $(this).find('input[name="name[]"]').val(),
                price: $(this).find('input[name="price[]"]').val(),
                stock: $(this).find('input[name="stock[]"]').val(),
                tax: $(this).find('select[name="tax[]"]').val(),
                total: $(this).find('input[name="total[]"]').val()
            };
            products.push(product);
        });
        // Store products as JSON string in the hidden input field
        $('#productsInput').val(JSON.stringify(products));
        $('#productModal').modal('hide');
    });
});

</script>
</body>
</html>