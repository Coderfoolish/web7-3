window.HSStaticMethods.autoInit();

async function getAllLoaiDoiTuong(page = 1, status = null, txt_search = null) {
    try {
        const response = await $.ajax({
            url: "./controller/LoaiDoiTuongController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                status: status,
                txt_search: txt_search
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadAllLoaiDoiTuong(page = 1, status = null, txt_search = null) {
    const res = await getAllLoaiDoiTuong(page, status, txt_search);
    if (res?.status == false && res?.message) {
        Swal.fire({
            title: "Thông báo",
            text: res.message,
            icon: "warning"
        });
        return;
    }
    if (res) {
        console.log(res);
        const LoaiDoiTuongList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#LoaiDoiTuong-list").empty();
        if (LoaiDoiTuongList.length == 0) {
            $("#LoaiDoiTuong-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không tìm thấy loại đối tượng.</td></tr>");
            $("#pagination").empty();
            return;
        }
        LoaiDoiTuongList.forEach(item => {
            $("#LoaiDoiTuong-list").append(`
              <tr>
                    <td>${item.dt_id}</td>
                    <td>${item.ten_dt}</td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-item btn btn-circle btn-text btn-sm edit-target hidden" aria-label="Action button" data-act="LoaiDoiTuong-sua" data-id="${item.dt_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="Action button" onclick="toggleStatus(${item.dt_id})"><span class="icon-[tabler--trash] size-5"></span></button>
                    </td>
                </tr>
            `);
        });
        window.AppState.applyPermissionControl();
        renderPagination(totalPages, currentPage);
    }
}

function renderPagination(totalPages, currentPage) {
    if (totalPages <= 1) {
        $("#pagination").empty();
        return;
    }

    $("#pagination").empty();

    $("#pagination").append(`<button type="button" class="btn btn-text btn-prev"><</button><div class="flex items-center gap-x-1">`);

    for (let i = 1; i <= totalPages; i++) {
        let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
        $("#pagination").append(`
            <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
        `);
    }

    $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next">></button>`);
}

function create() {
    const ten_LoaiDoiTuong = $("#ten-LoaiDoiTuong").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/LoaiDoiTuongController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "create",
            ten_dt: ten_LoaiDoiTuong,
            status: status
        },
        success: function (response) {
            if (!response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message
                });
            }
            else {
                Swal.fire({
                    icon: 'success',
                    title: 'Tạo thành công!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            history.back();
        },
        error: function (error) {
            console.error("Error navigate page:", error);

        }
    });
}

function update() {
    const LoaiDoiTuong_id = $("#LoaiDoiTuong_id").val();
    const ten_LoaiDoiTuong = $("#ten-LoaiDoiTuong").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/LoaiDoiTuongController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "update",
            dt_id: LoaiDoiTuong_id,
            ten_dt: ten_LoaiDoiTuong,
            status: status
        },
        success: function (response) {
            if (!response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message
                });
            }
            else {
                Swal.fire({
                    icon: 'success',
                    title: 'Lưu thay đổi thành công!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
            history.back();
        },
        error: function (error) {
            console.error("Error loading form sua:", error);
        }
    });
}

function toggleStatus(LoaiDoiTuong_id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn thay đổi trạng thái không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Có, thay đổi ngay',
        cancelButtonText: 'Không',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "./controller/LoaiDoiTuongController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "toggleStatus",
                    loaiDoiTuong_id: LoaiDoiTuong_id,
                },
                success: function (response) {
                    if (response?.status == false && response?.message) {
                        Swal.fire({
                            title: "Thông báo",
                            text: response.message,
                            icon: "warning"
                        });
                    } else {
                        if (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Đổi trạng thái thành công!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            const txtSearch = $("#search-keyword").val().trim();
                            const selectedValue = $("#select-status").val();
                            const status = selectedValue == -1 ? null : selectedValue;
                            loadAllLoaiDoiTuong(1, status, txtSearch);
                        }
                    }


                },
                error: function (error) {
                    console.error("Error loading form sua:", error);
                }
            });
        }
    });
}

$(document).ready(function () {
    loadAllLoaiDoiTuong(1);

    // Xử lý nút Lọc
    $("#btn-loc").on("click", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllLoaiDoiTuong(1, status, txtSearch);
    });

    $("#search-keyword").on("input", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllLoaiDoiTuong(1, status, txtSearch);
    });


    $("#btn-reset").on("click", function () {
        $("#select-status").val(-1);
        const txtSearch = $("#search-keyword").val().trim();
        loadAllLoaiDoiTuong(1, null, txtSearch);
    });


    $("#btn-create").on("click", function () {
        if ($("#ten-LoaiDoiTuong").val() != "") {
            create();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên Loại đối tượng không được để trống!'
            });
        }
    });

    $("#btn-save").on("click", function () {
        const tenLoaiDoiTuong = $("#ten-LoaiDoiTuong").val().trim();
        if (!tenLoaiDoiTuong) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên Loại đối tượng không được để trống!'
            });
            return;
        }

        Swal.fire({
            title: 'Bạn có chắc chắn muốn sửa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, sửa ngay',
            cancelButtonText: 'Không',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'

        }).then((result) => {
            if (result.isConfirmed) {
                update();
            }
        });
    });

    $("#pagination").on("click", ".btn-page", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == selectedPage) {
            return;
        }
        loadAllLoaiDoiTuong(selectedPage, status, txtSearch);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const txtSearch = $("#search-keyword").val().trim();
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        console.log(currentPage);
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        console.log(currentPage);
        loadAllLoaiDoiTuong(currentPage, status, txtSearch);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const txtSearch = $("#search-keyword").val().trim();
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        const totalPages = $("#pagination .btn-page").length;
        console.log(currentPage);
        if (currentPage == totalPages) {
            return;
        }
        currentPage += 1;
        console.log(currentPage);
        loadAllLoaiDoiTuong(currentPage, status, txtSearch);
    });
});