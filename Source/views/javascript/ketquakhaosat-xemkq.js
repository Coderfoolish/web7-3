window.HSStaticMethods.autoInit();

async function getKhaoSatById(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POSt",
            dataType: "json",
            data: {
                func: "getChiTietKsById",
                id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getAllMucKhaoSat(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getMucKhaoSat",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllCauHoi(mks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getCauHoi",
                mks_ids: mks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllKqks(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllByKsId",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllTraLoi(kqks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getTraLoi",
                kqks_ids: kqks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getAllLoaidt() {
    try {
        const response = await $.ajax({
            url: "./controller/LoaidtController.php",
            type: "GET",
            data: { func: "getAllLoaidt" },
            dataType: "json",
        });
        if (response.error) {
            console.log("fect", response.error);
        }
        return response;
    } catch (error) {
        console.log(error);
        console.log("loi fetchdata getAllKhaoSat 1");
        return null;
    }
}

async function getUserByIds(dt_ids) {
    try {
        const response = await $.ajax({

            url: "./controller/doiTuongController.php",
            type: "GET",
            data: { func: "getByIds", dt_ids: dt_ids },
            dataType: "json",
        });
        return response;
    } catch (error) {
        console.log("Lỗi khi lấy dữ liệu người dùng", error);
        return null;
    }
}

async function getAllByNhomKs(nhom_ks) {
    try {
        const response = await $.ajax({

            url: "./controller/doiTuongController.php",
            type: "GET",
            data: { func: "getAllByNhomKs", nhom_ks: nhom_ks },
            dataType: "json",
        });
        return response;
    } catch (error) {
        console.log("Lỗi khi lấy dữ liệu người dùng", error);
        return null;
    }
}

function taoBangThongKeTheoLoaiDT(ch, doiTuongThamGias, loaiDoiTuongs, traLoi, tongPhieuTheoLoaiDT, thamGiaTheoLoaiDT) {
    const container = document.createElement('div');
    container.className = 'mt-4';

    const title = document.createElement('h4');
    title.textContent = ch.noi_dung;
    title.className = 'font-semibold text-md mt-2';
    container.appendChild(title);

    const table = document.createElement('table');
    table.className = 'table-auto border-collapse border border-black w-full mt-2';

    // Header
    table.innerHTML = `
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-black px-2">Đối tượng</th>
                <th class="border border-black px-2">Tổng số</th>
                <th class="border border-black px-2">Tham gia</th>
                <th class="border border-black px-2">Trung bình</th>
            </tr>
        </thead>
    `;

    const tbody = document.createElement('tbody');

    let tongSo = 0, tongThamGia = 0, tongDiem = 0;

    loaiDoiTuongs.forEach(loai => {
        const dt_id = String(loai.dt_id);

        const tong = tongPhieuTheoLoaiDT.get(dt_id) || 0;
        if (tong === 0) return;

        const thamGiaDTs = doiTuongThamGias.filter(dt => String(dt.loai_dt_id) === dt_id);
        const thamGiaIds = new Set(thamGiaDTs.map(dt => dt.nguoi_lamks_id));
        const soThamGiaDT = thamGiaTheoLoaiDT.get(dt_id) || 0;

        let tongDiemDT = 0;
        traLoi.forEach(tl => {
            if (tl.ch_id === ch.ch_id && thamGiaIds.has(tl.nguoi_lamks_id)) {
                tongDiemDT += parseFloat(tl.ket_qua || 0);
            }
        });

        const trungBinh = soThamGiaDT > 0 ? (tongDiemDT / soThamGiaDT).toFixed(2) : '0.00';

        tongSo += tong;
        tongThamGia += soThamGiaDT;
        tongDiem += tongDiemDT;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border border-black px-2">${loai.ten_dt}</td>
            <td class="border border-black px-2 text-center">${tong}</td>
            <td class="border border-black px-2 text-center">${soThamGiaDT}</td>
            <td class="border border-black px-2 text-center">${trungBinh}</td>
        `;
        tbody.appendChild(row);
    });

    // Dòng tổng
    const tbAll = tongThamGia > 0 ? (tongDiem / tongThamGia).toFixed(2) : '0.00';
    const rowTong = document.createElement('tr');
    rowTong.className = 'font-semibold';
    rowTong.innerHTML = `
        <td class="border border-black px-2">Tổng / Trung bình</td>
        <td class="border border-black px-2 text-center">${tongSo}</td>
        <td class="border border-black px-2 text-center">${tongThamGia}</td>
        <td class="border border-black px-2 text-center">${tbAll}</td>
    `;
    tbody.appendChild(rowTong);

    table.appendChild(tbody);
    container.appendChild(table);

    // Thêm label cho ô Góp ý
    const label = document.createElement('label');
    label.textContent = 'Góp ý:';
    label.className = 'block mt-4 font-semibold';
    label.htmlFor = 'gop_y';

    // Thêm ô Góp ý
    const nhanXet = document.createElement('textarea');
    nhanXet.id = 'gop_y';
    nhanXet.className = 'w-full border border-gray-300 mt-2 p-2 rounded';
    nhanXet.placeholder = 'Góp ý...';

    // Thêm vào container
    container.appendChild(label);
    container.appendChild(nhanXet);

    return container;
}


async function loadDuLieu(ks_id) {

    // Lấy chi tiết khảo sát
    const khaoSat = await getKhaoSatById(ks_id);
    if (khaoSat?.status === false && khaoSat?.message) {
        Swal.fire({
            title: "Thông báo",
            text: khaoSat.message,
            icon: "warning"
        });
        return;
    }

    document.getElementById('ks-ten').textContent = khaoSat.ten_ks || 'Không rõ';
    document.getElementById('ks-ngaybatdau').textContent = khaoSat.ngay_bat_dau || 'Chưa có';
    document.getElementById('ks-ngayketthuc').textContent = khaoSat.ngay_ket_thuc || 'Chưa có';
    document.getElementById('ks-nganh').textContent = khaoSat.ten_nganh || 'Chưa có';
    document.getElementById('ks-chuky').textContent = khaoSat.ten_ck || 'Chưa có';
    document.getElementById('ks-nhom').textContent = khaoSat.ten_nks || 'Chưa có';

    // Lấy danh sách mục khảo sát
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);

    // Lấy danh sách câu hỏi theo mks_ids
    const cauHoi = await getAllCauHoi(mks_ids);

    // Lấy kết quả khảo sát
    const kqks = await getAllKqks(ks_id);
    const kqks_ids = kqks.data.map(item => item.kqks_id);
    const doiTuong_Ids = kqks.data.map(item => item.nguoi_lamks_id);

    const loaiDoiTuongs = await getAllLoaidt();
    const doiTuongThamGias = await getUserByIds(doiTuong_Ids);
    const doiTuongs = await getAllByNhomKs(khaoSat.nks_id);

    console.log(loaiDoiTuongs);
    console.log(doiTuongs);
    console.log(doiTuongThamGias);

    const thongKeKhaoSat = document.getElementById('thongke-khaosat');

    const tongSoPhieu = document.createElement('p');
    tongSoPhieu.className = "mt-2 text-md font-medium text-gray-700";
    tongSoPhieu.innerHTML = `<strong>Tổng số phiếu: </strong> <span>${doiTuongs.length}</span>`;
    thongKeKhaoSat.appendChild(tongSoPhieu);

    const soLuongThamGia = document.createElement('p');
    soLuongThamGia.className = "mt-2 text-md font-medium text-gray-700";
    soLuongThamGia.innerHTML = `<strong>Số lượng tham gia khảo sát: </strong> <span>${kqks_ids.length}</span>`;
    thongKeKhaoSat.appendChild(soLuongThamGia);

    const tongPhieuTheoLoaiDT = new Map();
    doiTuongs.forEach(item => {
        const key = String(item.loai_dt_id);
        tongPhieuTheoLoaiDT.set(key, (tongPhieuTheoLoaiDT.get(key) || 0) + 1);
    });

    const thamGiaTheoLoaiDT = new Map();
    doiTuongThamGias.forEach(item => {
        const key = String(item.loai_dt_id);
        thamGiaTheoLoaiDT.set(key, (thamGiaTheoLoaiDT.get(key) || 0) + 1);
    });

    loaiDoiTuongs.forEach(item => {
        const key = String(item.dt_id);
        const tong = tongPhieuTheoLoaiDT.get(key) || 0;
        const thamgia = thamGiaTheoLoaiDT.get(key) || 0;
        if (tong == 0) {
            return;
        }
        const p = document.createElement('p');
        p.className = "mt-2 text-md font-medium text-gray-700";
        p.innerHTML = `<strong>${item.ten_dt}:</strong> Tổng phiếu: <span>${tong}</span>, Tham gia: <span>${thamgia}</span>`;
        thongKeKhaoSat.appendChild(p);
    });

    // Lấy danh sách trả lời
    const traLoi = await getAllTraLoi(kqks_ids);

    // loai tra loi
    document.getElementById('ks-ltl').textContent = `${khaoSat.thang_diem} - ${khaoSat.ltl_mota}`;

    const ltlContainer = document.getElementById("ltl-container");

    const chitiet_mota = khaoSat.ltl_chitiet_mota ? khaoSat.ltl_chitiet_mota.split(",").map(item => item.trim()) : null;
    chitiet_mota.forEach((item, index) => {
        const section = document.createElement("div");
        section.className = `p-4 section min-w-[125px] min-h-[125px] rounded-full item-center`;
        section.innerHTML = `
                    <div>
                        <h3 class='mt-3 text-center'>${index + 1}</h3>
                    </div>
                    <div>
                        <p class='mt-3 text-center'>${item}</p>
                    </div>
                `;
        ltlContainer.appendChild(section);
    });

    // Tạo nội dung bảng
    const ketQuaList = document.getElementById('ketqua-list');
    ketQuaList.innerHTML = '';

    const mksTheoCha = new Map();
    mucKhaoSat.forEach(mks => {
        const parentId = mks.parent_mks_id || 'root';
        if (!mksTheoCha.has(parentId)) {
            mksTheoCha.set(parentId, []);
        }
        mksTheoCha.get(parentId).push(mks);
    });

    const cauHoiTheoMks = new Map();
    cauHoi.forEach(ch => {
        if (!cauHoiTheoMks.has(ch.mks_id)) {
            cauHoiTheoMks.set(ch.mks_id, []);
        }
        cauHoiTheoMks.get(ch.mks_id).push(ch);
    });

    const traLoiTheoCauHoi = new Map();
    traLoi.forEach(tl => {
        const key = `${tl.ch_id}-${tl.ket_qua}`;
        traLoiTheoCauHoi.set(key, (traLoiTheoCauHoi.get(key) || 0) + 1);
    });

    // Duyệt các mục cha
    const mucChaList = mksTheoCha.get('root') || [];
    mucChaList.forEach((mucCha, indexMuc) => {
        const tieude = document.createElement('h3');
        tieude.textContent = mucCha.ten_muc;
        tieude.style.marginTop = '30px';
        tieude.style.fontWeight = 'bold';
        ketQuaList.appendChild(tieude);

        const mucConList = mksTheoCha.get(mucCha.mks_id) || [];

        if (mucConList.length > 0) {
            mucConList.forEach((mucCon, indexMucCon) => {
                const subTitle = document.createElement('h4');
                subTitle.textContent = `${indexMuc + 1}.${indexMucCon + 1} ${mucCon.ten_muc}`;
                subTitle.style.marginTop = '15px';
                subTitle.style.fontWeight = 'bold';
                ketQuaList.appendChild(subTitle);

                const relatedQuestions = cauHoiTheoMks.get(mucCon.mks_id) || [];
                relatedQuestions.forEach((ch, indexCH) => {
                    const bangTK = taoBangThongKeTheoLoaiDT(
                        ch, doiTuongThamGias, loaiDoiTuongs, traLoi, tongPhieuTheoLoaiDT, thamGiaTheoLoaiDT
                    );

                    ketQuaList.appendChild(bangTK);
                });
            });
        } else {
            const relatedQuestions = cauHoiTheoMks.get(mucCha.mks_id) || [];
            relatedQuestions.forEach((ch, indexCH) => {
                const bangTK = taoBangThongKeTheoLoaiDT(
                    ch, doiTuongThamGias, loaiDoiTuongs, traLoi, tongPhieuTheoLoaiDT, thamGiaTheoLoaiDT
                );

                ketQuaList.appendChild(bangTK);
            });
        }
    });

}

function xuatExel(ks_id) {
    Swal.fire({
        title: 'Đang xử lý...',
        text: 'Vui lòng chờ trong giây lát',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $.ajax({
        url: './controller/ketQuaKhaoSatController.php',
        type: 'GET',
        data: {
            func: "xuatExel",
            ks_id: ks_id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            Swal.close();
            if (response?.status === false && response?.message) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "warning"
                });
            } else {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `survey_export_${ks_id}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        },
        error: function (xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}

function printDiv() {
    const infoHTML = document.getElementById("print-info-khaosat")?.innerHTML || "";
    const loaiTraLoiHTML = document.getElementById("print-loaitraloi-khaosat")?.innerHTML || "";
    const ketQuaHTML = document.getElementById("print-ketqua-khaosat")?.innerHTML || "";
    const khaoSatTitle = document.getElementById("ks-ten")?.innerText || "Kết quả khảo sát";

    const printWindow = window.open('', '', 'height=600,width=800');

    // Lấy toàn bộ <link rel="stylesheet"> và <style>
    let styles = '';
    document.querySelectorAll('link[rel="stylesheet"], style').forEach(el => {
        styles += el.outerHTML;
    });

    const htmlContent = `
        <html>
            <head>
                <title>${khaoSatTitle}</title>
                ${styles}
            </head>
            <body>
                <div>${infoHTML}</div>
                <div>${loaiTraLoiHTML}</div>
                <div>${ketQuaHTML}</div>
            </body>
        </html>
    `;

    printWindow.document.open();
    printWindow.document.write(htmlContent);
    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}
$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const ks_id = urlParams.get('id');
    console.log(ks_id);
    loadDuLieu(ks_id);

    $('#excel').on('click', function () {
        xuatExel(ks_id);
    });

    $('#pdf').on('click', function () {
        printDiv();
    });
});