$(document).ready(function () {
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });


    $('.dynamic').change(function () {

        if ($(this).val() != '') {

            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = 'name';
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '/fetch-dependent',
                method: "POST",
                data: {select: select, value: value, token: _token, dependent: dependent},
                success: function (result) {
                    $('.brand').html(
                        '<select name="brand" id="brand" data-placeholder="Select Brand" class="form-control chosen-select r_dynamic" data-dependent="release">' +
                        result +
                        '</select>'
                    );
                    $('select').chosen();
                    bindSelect();
                }
            })
        }
    });

    function bindSelect() {
        $('.r_dynamic').change(function () {

            if ($(this).val() != '') {

                var select = 'parent_id';
                var value = $(this).val();

                var dependent = 'name';

                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '/fetch-dependent',
                    method: "POST",
                    data: {select: select, value: value, token: _token, dependent: dependent},
                    success: function (result) {
                        $('.release').html(
                            '<select name="release" id="release" data-placeholder="Select Release" class="form-control chosen-select" data-dependent="release">' +
                            result +
                            '</select>'
                        );
                        $('select').chosen();
                    }
                })
            }
        });
    }

    $('#comment_form').on('submit', function (event) {
        event.preventDefault();
        var form_data = new FormData(this);
        $.ajax({
            url: ADDFEEDBACK,
            method: "POST",
            data: form_data,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                console.log(data['comment'].message);
                $('.comment_text').append(
                    '<p class="mb-1">' +
                    '<input type="hidden" class="feedback_id" name="feedback_id" value="' + data['comment'].id + '">' +
                    '<input type="hidden" class="feedback_message" name="feedback_message" value="' + data['comment'].message + '">' +
                    '<span class="float-right" class="comment" role="group">' +
                    '<button id="comment_btn" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">' +
                    '<i class="fas fa-ellipsis-h"></i>' +
                    '</button>' +
                    '<span class="dropdown-menu" aria-labelledby="comment_btn">' +
                    '<button type="submit" class=" btn edit" name="edit" id="edit" data-toggle="modal" data-target="#myModal"><a href="#">Edit</a></button>' +
                    '<button type="submit" class="btn delete_btn" name="remove" id="remove"><a href="/remove-feedback/' + data["comment"].id + '">Delete</a></button>' +
                    '</span>' +
                    '</span>' +
                    '<span>' +
                    data['userName'] +
                    '</span>' +
                    '<label class="ml-4">' +
                    '<small>' +
                    data['comment'].created_at +
                    '</small>' +
                    '</label>' +
                    '</p>' +
                    '<span>' +
                    data['comment'].message +
                    '</span>'
                );
                $('#comment_form')[0].reset();
            },
            error: function (error) {
                // window.location.href = HOME;
            }
        });
    });
    $('#slider').on('submit', function (event) {
        event.preventDefault();
        var form_data = new FormData(this);
        $.ajax({
            url: SORTSlIDER,
            method: "POST",
            data: form_data,
            Type: "JSON",
            contentType: false,
            processData: false,
            success: function ($result) {
                if ($result) {
                    console.log($result);
                    $('#my_tag').html('');
                    $('#my_tag').html($result);
                }
            },
            error: function (error) {
                console.log(error.responseJSON);
            }
        });
    });
    z = 0;
    view = '';
    $('.car_brand').on('click', function (event) {
        if (z == 0) {
            view = $('#my_tag').html();
            z++;
        }
        var checkboxValues = [];
        var data1 = [];
        $('input[type="checkbox"]:checked').each(function (index, elem) {
            console.log('elem' + elem);
            data1[index] = $('input[type="checkbox"]:checked').eq(index).val();
            console.log(data1);
        });

        $.ajax({
            url: SORTCHECKBOX,
            method: "post",
            data: {data: data1},
            Type: "JSON",
            success: function (result) {
                $('#my_tag').html('');
                $('#my_tag').html(result);
            },
            error: function (error) {
                $('#my_tag').html('');
                $('#my_tag').html(view);
            }
        });

    });

    $('.vendor_manufacturare').on('click', function (event) {
        if (z == 0) {
            view = $('#my_tag').html();
            z++;
        }
        var checkboxValues = [];
        var data1 = [];
        $('input[type="checkbox"]:checked').each(function (index, elem) {
            console.log('elem' + elem);
            data1[index] = $('input[type="checkbox"]:checked').eq(index).val();
            console.log(data1);
        });

        $.ajax({
            url: SORTCHECKBOXVENDOR,
            method: "post",
            data: {data: data1},
            Type: "JSON",
            success: function (result) {
                $('#my_tag').html('');
                $('#my_tag').html(result);
            },
            error: function (error) {
                $('#my_tag').html('');
                $('#my_tag').html(view);
            }
        });

    });

    $(document).on('click', '.edit', function () {
        $id = $(this).parents('p').children('.feedback_id').val();
        $message = $(this).parents('p').children('.feedback_message').val();
        $('.my_id').val($id);
        $('.my_message').val($message);
    });


    $('input[name="type"]').click(function () {
        if ($('#option').prop('checked')) {
            $('.peckeges_pane').css('display', 'block');
        } else {
            $('.peckeges_pane').css('display', 'none');
        }
    });
    $('#project').css('display', 'none');
    $('.rad').click(function () {
        if ($('#nodeal').prop('checked')) {
            $('#project').css('display', 'none');
            $("[name='buy_product']").prop('required', false);
            $("[name='get_product']").prop('required', false);
        }
        if ($('#deal').prop('checked')) {
            $('#project').css('display', 'block');
            $("[name='buy_product']").prop('required', true);
            $("[name='get_product']").prop('required', true);
        }
    });

    $(document).on('click', '.status', function (e) {
        e.preventDefault();
        var btn = $(this);
        var status = $(this).children('span').text();
        console.log(status);
        if (status === 'UnBlocked') {
            status = 'Blocked';
        } else {
            status = 'UnBlocked';
        }
        var id = $(this).attr('id');
        console.log(id);
        $.ajax({
            url: '/statusActive',
            type: 'get',
            data: {user_id: id},
            success: function (data) {
                console.log(data);
                $(btn).parent('td').siblings('.check_active').text(data.is_active);
                $(btn).parent('td').siblings('.restore').text(data.status);
                $(btn).children('span').text(status);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $(document).on('click', '.cart_btn', function (e) {
        e.preventDefault();
        var btn = $(this);
        var formData = $(this).parents('form').serialize();
        console.log(formData);
        $.ajax({
            url: '/add-to-cart',
            method: "get",
            data: formData,
            success: function JSalert(result) {
                $('.cart_quantity').text(result);
                console.log(result);
                swal("Successfully!", "Product Added into Cart", "success");
            },
            error: function ($result) {
                console.log($result);
            }
        });
    });

    $(document).on('click', '.goto_login', function () {
        window.location.href = HOME;
    });

    $(document).on('click', '.delete_cart', function (e) {
        e.preventDefault();
        var check = confirm('Do you want remove item from cart');
        if (check) {
            var btn = $(this);
            var parent = $(this).parent('td').parent('tr');
            var cartId = $(this).parent('td').siblings("[name='product_id']").val();
            var netAmount = $('.cart_amount .amount').html();
            var subTotal = $(this).parent('td').siblings('.product_total').text();
            $.ajax({
                url: '/delete-cart',
                method: "get",
                data: {id: cartId},
                success: function JSalert(result) {
                    console.log(result);
                    $(parent).html('');
                    if (result == 0) {
                        $('.shipping').html('');
                        $('.total_amount').html(0);
                        $('.checkout_btn a').attr('href', '#');
                    }
                    $('.checkout_btn a').removeAttr('href');
                    $('.sub_total').html(Number(netAmount) - Number(subTotal));
                    $('.total_amount').html(Number(netAmount) - Number(subTotal) + Number($('.total_shipping').text()));
                    $('.cart_quantity').text(result);
                    swal("Success!", "Product remove from Cart Successfullly", "success");
                }
            });
        }
    });

    function reduceCart(id, quantity, subTotalField, ucp, netAmount, difference) {

        $.ajax({
            url: '/delete-cart-item',
            method: 'get',
            data: {product_id: id, get_quantity: difference},
            success: function (result) {
                var qty = $('.cart_quantity').html();
                $('.cart_quantity').text(Number(qty) + Number(difference));
                $('.main_body').html('');
                $('.main_body').html(result);
                $(subTotalField).html(ucp * quantity);
                $('.cart_amount .cart_amount .amount').html(Number(netAmount) - Number((-1 * difference) * ucp));
            }
        });
    }

    $(document).on('change', '.item_qty', function () {
        var product_id = $(this).siblings("[name='product_id']").val();
        var itemQuantity = $(this).siblings("[name='item_quantity']").val();
        var quantity = $(this).val();
        var subTotal = $(this).parent('td').siblings('.product_total').text();
        var subTotalField = $(this).parent('td').siblings('.product_total');
        var ucp = $(this).parent('td').siblings(".product-price").text();
        var product_quantity = $(this).attr('max');
        var netAmount = $('.cart_amount .cart_amount .amount').html();

        console.log('product_id', product_id);
        console.log('new', quantity);
        console.log('old', itemQuantity);
        console.log('max', product_quantity);
        console.log('ucp', ucp);
        console.log('net amount', netAmount);
        var difference = quantity - itemQuantity;
        console.log('difference', difference);
        if (parseInt(quantity) > product_quantity) {
            swal('Alert!', 'Sorry, you can only purchase allowable quantity of this product.', 'warning');
            $(this).val(itemQuantity);
        } else if (parseInt(quantity) < parseInt(itemQuantity)) {
            reduceCart(product_id, quantity, subTotalField, ucp, netAmount, difference);
        } else {
            $.ajax({
                url: '/update-cart',
                method: 'get',
                data: {product_id: product_id, get_quantity: difference},
                success: function (result) {
                    console.log('result', result);
                    var qty = $('.cart_quantity').html();
                    $('.cart_quantity').text(Number(qty) + Number(difference));
                    $('.main_body').html('');
                    $('.main_body').html(result);
                    $(subTotalField).html(ucp * quantity);
                    $('.cart_amount .cart_amount .amount').html(Number(netAmount) + Number(difference * ucp));
                }
            });
        }
    });

    function fetchData(page, value) {
        $.ajax({
            url: SORTPRO + '?page=' + page,
            method: 'get',
            data: {value: value},
            type: JSON,
            success: function ($result) {
                // console.log($result);
                $('#my_tag').html('');
                $('#my_tag').html($result);
            },
            error: function ($result) {
                console.log($result);
            }

        });
    }

    $('.short').change(function () {
        var value = $(this).val();
        var page = $('#hidden_page').val();
        $('#hidden_option').val(value);
        // console.log(page);
        fetchData(page, value);


    });


    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var value = $('#hidden_option').val();
        console.log('page' + page);
        console.log('value' + value);
        fetchData(page, value)

    });

    $(document).on('change', '.get_quantity', function () {
        var cartId = $(this).parent('td').siblings("[name='cart_id']").val();
        var itemQuantity = $(this).parent('td').siblings("[name='item_quantity']").val();
        var quantity = $(this).val();
        var subTotal = $(this).parent('td').siblings('.product_total');
        var ucp = $(this).parent('td').siblings("[name='ucp']").val();
        var product_quantity = $(this).attr('max');
        if (parseInt(quantity) > product_quantity) {
            alert('Sorry, you can only purchase allowable quantity of this product.');
            $(this).val(product_quantity);
        }
    });


    $('.wish').on('click', function () {
        // event.preventDefault();
        var id = $(this).attr('id');
        var product_id = $(this).next().val();
        // alert(product_id);
        var data = {
            _token: $(this).attr('data-token'),
            product_id: product_id,
            user_id: id
        };
        $.ajax(
            {
                url: ADDWISH,
                method: "get",
                data: data,
                success: function JSalert(data) {
                    if (data) {
                        swal("Successfully!", "Product Added in wish list", "success");
                    }
                    $('.wishlist_quantity').text(data)
                },
                error: function JSalert(data) {
                    swal("Information!", "Product Already exist in your Wish List", "info");
                }
            });
    });
    $(document).on('click', '.delete_wish', function (e) {
        e.preventDefault();
        var parent = $(this).parent('td').parent('tr');
        var id = $(this).attr('id');
        $.ajax({
            url: DELWISH,
            method: 'get',
            data: {id: id},
            success: function (result) {
                console.log(result , parent)
                $(parent).html("");
                $('.wishlist_quantity').text(result)
            }
        })
    });

    $(document).on('click', '.delete_user', function () {
        var id = $(this).siblings('input').val();
        var row = $(this).parent('td').parent('tr');
        var btn = $(this);
        console.log('value', id);
        var check = confirm('Do you want to delete vendor?');
        if (check) {
            $.ajax({
                url: REJREQ,
                type: 'get',
                data: {id: id},
                success: function (data) {
                    console.log(data);
                    $(btn).parents('#content-wrapper').html(
                        '<img src="' + ASSET + '">'
                    );
                }

            });
        }
    });
    i = 0;
    $(document).on('click', '.quick_button', function () {
        var name = $(this).siblings('[name="product_name"]').val();
        var price = $(this).siblings('[name="price"]').val();
        var old_price = $(this).siblings('[name="old_price"]').val();
        var description = $(this).siblings('[name="description"]').val();
        var condition = $(this).siblings('[name="condition"]').val();
        var id = $(this).siblings('[name="id"]').val();
        var quantity = $(this).siblings('[name="quantity"]').val();
        var images = $(this).siblings('[name="images"]').val();
        var length = $(this).siblings('[name="image_size"]').val();
        $('.modal_title').children('h2').html(name);
        $('.modal_price .current_price').html('PKR. ' + price);
        if (old_price === price) {
            $('.modal_price .old_price').html('');
        } else {
            $('.modal_price .old_price').html(old_price);
        }
        console.log('i: ', i);
        console.log('image: ', name);
        if (i > 0) {
            var element = $('.modal_tab_img').children('.modal_img').children('img').attr('src');
            var res = element.split('/');
            var newSrc = res[0] + '/' + res[1] + '/' + res[2] + '/' + res[3] + '/' + res[4] + '/' + images;
            $('.modal_tab_img').children('.modal_img').children('img').attr('src', '');
            $('.modal_tab_img').children('.modal_img').children('img').attr('src', newSrc);
        } else {
            element = $('.modal_tab_img').children('.modal_img').children('img').attr('src');
            var newSrc = element + '/' + images;
            $('.modal_tab_img').children('.modal_img').children('img').attr('src', newSrc);
            i++;
        }
        $('.modal_description').children('p').html(description);
        $('.modal_cart').children(' [name="product_id"]').val(id);
        $('.modal_cart').children(' [name="get_quantity"]').attr('max', quantity);
        $('.condition').html(condition);
        console.log(newSrc);
    });

    $(document).on('keyup', '.search_product_name', function () {
        var formData = $(this).parents('.search_form').serialize();
        var value = $(this).val();
        console.log(value);
        if (value !== '') {
            $.ajax({
                url: '/search-products-list',
                type: 'get',
                data: formData,
                success: function (data) {
                    $('.product_list').fadeIn();
                    $('.product_list').html(data);
                }
            });
        } else {
            $('.product_list').fadeOut();
        }
    });

    $(document).on('click', '.product_list div a', function () {
        $('.search_product_name').val($(this).text());
        $('.product_list').fadeOut();
        $('.search_product_name').parents('.search_form').submit();
    });

    $(document).on('click', '.view_description', function () {
        var data = $(this).siblings('[name="description"]').val();
        $('.modal-body').html(data);
    });

    $(document).on('click', '.view_image', function () {
        // for (i=0 ; i<=)
        var length = $(this).siblings('[name="count"]').val();
        data = '';
        arr = '';
        count = 0;
        $('.btnShowPopup').html('');
        for (var i = 0; i < length; i++) {
            data = $(this).siblings('[name="image' + i + '"]').val();
            $('.btnShowPopup').append('<img src="' + data + '">');
            arr += [data];
            count++;
        }
    });


    $(document).on('click', '.view_comments', function () {
        $(this).parents('form').submit();
    });

    $(document).on("focusin", ".location", function () {
        $(this).prop('readonly', true);
    });

    $(document).on("focusout", ".location", function () {
        $(this).prop('readonly', false);
    });

    $(document).on('click', '.remark_btn', function () {
        var value = $(this).parent('td').parent('tr').siblings('[name="id"]').val();
        console.log(value);
        var set = $('[name="vendor_id"]').val(value);
    });

    $(document).on('click', '.close', function () {
        $(this).parent('.alert').css('display', 'none');
    });
    // $('.sel').chosen({placeholder:'This is placeholder'});
});




