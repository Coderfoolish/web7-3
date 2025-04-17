window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getKhaoSatByPageNumber(page = 1) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getKhaoSatByPageNumber", number: page },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata getAllKhaoSat");
    return null;
  }
}
async function deleteKs(id) {
  console.log("de", id);
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "deleteKs", id: id },
      dataType: "json",
    });
    if (response) {
      alert("xóa khảo sát thành công");
      $("#khao-sat-page").trigger("click");
    } else {
      alert("xóa khảo sát thất bại");
    }
    return response;
  } catch (error) {
    console.log("loi xoa khao sat ");
    return null;
  }
}
async function getKhaoSatById() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: JSON.stringify({ func: "getKhaoSatById", data: { ks_id: 1 } }),
    });
    // response is json type
    return { data: response, error: null }; // Directly return the JSON response
  } catch (error) {
    console.log("loi fetchdata getKhaoSatById");
    return null;
  }
}
async function renderAllKhaoSat(page = 1, status = null) {
  const res = await getKhaoSatByPageNumber(page, status);
  status = null;
  if (res) {
    const ksList = res.data;
    const totalPages = res.totalPages;
    const currentPage = res.currentPage;
    $("#ks-list").empty();
    $("#pagination").empty();
    if (ksList != null) {
      ksList.map((item) => {
        $("#ks-list").append(`
            <tr>
                <td>${item.ten_ks}</td>
                <td>${item.ngay_bat_dau}</td>
                <td>${item.ngay_ket_thuc}</td>
                <td class="text-center">
                ${
                  item.su_dung == 1
                    ? '<span class="badge badge-soft badge-success ">Đang thực hiện</span>'
                    : '<span class="badge badge-soft badge-error ">Kết thúc</span>'
                }
                </td>
                <td>
                  <button class="action-item btn btn-circle btn-text btn-sm" data-act="ks-sua" data-id="${
                    item.ks_id
                  }" aria-label="sua khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                  <button onclick="deleteKs(${
                    item.ks_id
                  })" class="btn btn-circle btn-text btn-sm" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
                </td>
            </tr>
    
          `);
      });
    }
    $("#pagination").append(
      `<button type="button" class="btn btn-text btn-prev">Previous</button><div class="flex items-center gap-x-1">`
    );
    for (let i = 1; i <= totalPages; i++) {
      let activeClass = i == currentPage ? 'aria-current="page"' : "";
      $("#pagination").append(`
              <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
          `);
    }
    $("#pagination").append(
      `</div><button type="button" class="btn btn-text btn-next">Next</button>`
    );
  }
}
$(function () {
  renderAllKhaoSat();

  $("#pagination").on("click", ".btn-page", function () {
    const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        console.log(currentPage)
        console.log(selectedPage)
        if (currentPage == selectedPage) {
            return;
        }
    renderAllKhaoSat(selectedPage, status);
  });

  $("#pagination").on("click", ".btn-prev", function () {
    let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
    if (currentPage == 1) {
      return;
    }
    currentPage -= 1;
    renderAllKhaoSat(currentPage);
  });

  $("#pagination").on("click", ".btn-next", function () {
    let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
    console.log("pre",currentPage)
    if (currentPage == $("#pagination .btn-page").length) {
      return;
    }
    currentPage += 1;
    renderAllKhaoSat(currentPage);
  });
});

