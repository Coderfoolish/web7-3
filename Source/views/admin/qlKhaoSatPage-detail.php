<div class="flex items-center justify-between mb-4">
    <a href="" class="back-link btn btn-soft ">Quay lại</a>
</div>
<div class="flex w-full justify-center">
    <div class="flex flex-col ">
        <h3 class="modal-title mb-8">Thông tin chi tiết</h3>

        <div class="">
            <!-- thong tin chung -->
            <div class="flex flex-row">
                <div class="pt-0 mb-4">
                    <div class="mb-2">
                        <label class="label-text" for="ten-ks"> Tên bài khảo sát </label>
                        <input disabled type="text" placeholder="Jack Sparrow" class="input" id="ten-ks" />
                    </div>
                    <div class="relative max-w-sm">
                        <label class="label-text" for="select-nhomks-box"> Tên nhóm khảo sát </label>
                        <div id="select-nhomks-box"
                            class="border border-gray-300 rounded-md p-2 cursor-pointer bg-white">
                            <span id="selected-nhom-ks">Chọn nhóm</span>
                        </div>
                        <div id="nhomKsDropdown"
                            class=" hidden absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <input disabled type="text" id="nhomKsInput" placeholder="Chọn nhóm "
                                class="p-2 w-full border-b border-gray-300 focus:outline-none" />
                            <div id="list-nhomks-option" class="max-h-60 overflow-y-auto">
                            </div>
                        </div>
                    </div>
                    <div class="mb-0.5 flex gap-4 max-sm:flex-col mb-2">
                        <div class="w-full">
                            <label class="label-text" for="begin"> Bắt đầu </label>
                            <input disabled type="date" class="input" id="begin" />
                        </div>
                        <div class="w-full">
                            <label class="label-text" for="end"> Kết thúc</label>
                            <input disabled type="date" class="input" id="end" />
                        </div>
                    </div>

                </div>
                <div class="modal-body pt-0 mb-4">
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-loai-tra-loi">Loại câu trả lời </label>
                        <select class="select" disabled id="select-loai-tra-loi">
                            <option>Chọn loại</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-nganh">Ngành </label>
                        <select class="select" disabled id="select-nganh">
                            <option value="-1">Chọn ngành</option>
                        </select>
                    </div>
                    <div class="w-96 mb-[1.5px]">
                        <label class="label-text" for="select-chu-ki">Chu kì</label>
                        <select class="select" disabled id="select-chu-ki">
                            <option value="-1">Chọn chu kì</option>
                        </select>
                    </div>
                    <div class="w-96 ">
                        <label class="label-text" for="select-ks-type">Loại khảo sát</label>
                        <select class="select" disabled id="select-ks-type">
                            <option value="1">Chương trình đào tạo</option>
                            <option value="0">Chuẩn đầu ra</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body pt-0 mb-4">
                    <div class="w-96 mb-4">
                        <label class="label-text" for="select-su-dung">Trạng thái bài khảo sát </label>
                        <select class="select" id="select-su-dung">
                            <option value="2">Chưa bắt đầu</option>
                            <option value="1">Đang thực hiện</option>
                            <option value="0">Kết thúc</option>
                        </select>
                    </div>
                    <button id="btn-update-used-survey-status" class="btn btn-check">
                        Cập nhật trạng thái sử dụng
                    </button>
                </div>
            </div>
            <!-- cau hoi -->
            <div class="modal-body pt-0 mb-4">
                <p class="mb-4">
                    Nội dung khảo sát
                </p>
                <div id="survey-container"></div>

            </div>
        </div>
    </div>
</div>
<!-- <script src="views/javascript/qlKhaoSatPage-edit.js"></script> -->
<script>
    async function getNhomKs() {
        try {
            const response = await $.ajax({
                url: "./controller/nhomKsController.php",
                type: "GET",
                data: {
                    func: "getAllNhomKs"
                },
                dataType: "json",
            });
            console.log("fect", response);
            return response;
        } catch (error) {
            console.log(error);
            console.log("loi fetchdata getAllKhaoSat 1");
            return null;
        }
    }
    async function getAllNganh() {
        try {
            const response = await $.ajax({
                url: "./controller/nganhController.php",
                type: "GET",
                data: {
                    func: "getAll"
                },
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
    async function getAllChuKi() {
        try {
            const response = await $.ajax({
                url: "./controller/chuKiController.php",
                type: "GET",
                data: {
                    func: "getAllChuKi"
                },
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
    async function getAllTraLoi() {
        try {
            const response = await $.ajax({
                url: "./controller/loaiTraLoiController.php",
                type: "GET",
                data: {
                    func: "getAllTraLoi"
                },
                dataType: "json",
            });
            if (response.error) {
                console.log("fect", response.error);
            }
            console.log("fect", response);
            return response;
        } catch (error) {
            console.log(error);
            console.log("loi fetchdata getAllKhaoSat 1");
            return null;
        }
    }
    async function updateKhaoSat(data) {
        try {
            const response = await $.ajax({
                url: "./controller/KhaoSatController.php",
                type: "POST",
                data: {
                    func: "updateKhaoSat",
                    data: JSON.stringify(data)
                },
                dataType: "json",
            });
            if (response.error) {
                console.log("fect", response.error);
            }
            console.log("update", response);
            return response;
        } catch (error) {
            console.log(error);
            console.log("loi  tao khao sat");
            return false;
        }
    }
    //return -1:not found || ctdt id
    async function checkExistCtdt(nganh_id, chu_ki_id, is_ctdt_daura) {
        console.log("check exit input", nganh_id, chu_ki_id, is_ctdt_daura);
        try {
            const response = await $.ajax({
                url: "./controller/KhaoSatController.php",
                type: "POST",
                data: {
                    func: "checkExistCtdt",
                    data: JSON.stringify({
                        nganh_id: nganh_id,
                        chu_ki_id: chu_ki_id,
                        is_ctdt_daura: is_ctdt_daura,
                    }),
                },
            });
            return response; // return id cdtd tim duoc
        } catch (e) {
            console.log("loi fetchdata loi kiem tra ctdt", e);
            return -1;
        }
    }
    async function getChiTietKsById(id) {
        try {
            const response = await $.ajax({
                url: "./controller/KhaoSatController.php",
                type: "POST",
                data: {
                    func: "getChiTietKsById",
                    id: id
                },
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
    async function getSurveryContentQuestion(id) {
        try {
            const response = await $.ajax({
                url: "./controller/KhaoSatController.php",
                type: "POST",
                data: { func: "getSurveyContentBySurveyId", ksId: id },
                dataType: "json",
            });
            if (response.status === "error") {
                Swal.fire({
                    title: "Thông báo",
                    html: response.message,
                    icon: "warning",
                });
                return null;
            }
            return response.data;
        } catch (e) {
            console.log(e);
            console.log("loi fetchdata noi dung ks ");
            return null;
        }
    }
    $(function () {
        window.HSStaticMethods.autoInit();
        (async () => {
            const urlParams = new URLSearchParams(window.location.search);

            const currentKsId = urlParams.get('id');
            const defaultData = await getChiTietKsById(currentKsId);
            const nhomKsList = await getNhomKs();
            const nganhList = await getAllNganh();
            const chuKiList = await getAllChuKi();
            const answerTypeList = await getAllTraLoi();
            const surveyContent = await getSurveryContentQuestion(currentKsId);


            if (nhomKsList != null) {
                nhomKsList.map((item) => {
                    $("#list-nhomks-option").append(
                        `<div class="nhomks-option p-2 hover:bg-gray-200 cursor-pointer" 
          data-value='${item.nks_id}'>${item.ten_nks}</div>
          `
                    );
                });
            }
            if (nganhList != null) {
                nganhList.map((item) => {
                    if (item.nganh_id == defaultData.nganh_id) {
                        $("#select-nganh").append(
                            `<option value='${item.nganh_id}' selected="selected">${item.ten_nganh}</option>`
                        );
                    }
                    $("#select-nganh").append(
                        `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
                    );
                });
            }
            if (chuKiList != null) {
                chuKiList.map((item) => {
                    if (item.ck_id == defaultData.ck_id) {
                        $("#select-chu-ki").append(
                            `<option selected="selected" value='${item.ck_id}'>${item.ten_ck}</option>`
                        );
                    }
                    $("#select-chu-ki").append(
                        `<option value='${item.ck_id}'>${item.ten_ck}</option>`
                    );
                });
            }
            if (answerTypeList != null) {
                answerTypeList.map((item) => {
                    if (defaultData.ltl_id == item.ltl_id) {
                        $("#select-loai-tra-loi").append(
                            `<option selected="selected" value='${item.ltl_id}'>${item.thang_diem}</option>`
                        );
                    }
                });
            }
            //xu li gia tri mac dinh
            $("#select-su-dung").val(defaultData.su_dung);
            $("#select-ks-type").val(defaultData.la_ctdt);
            $("#ten-ks").val(defaultData.ten_ks);
            $("#begin").val(defaultData.ngay_bat_dau);
            $("#end").val(defaultData.ngay_ket_thuc);
            $("#selected-nhom-ks").val(defaultData.nks_id);
            const defaultNhomKsValue = defaultData.nks_id;
            // xu ly select search nhom khao sat
            const selectNhomKsBox = document.getElementById("select-nhomks-box");
            const nhomKsDropdown = document.getElementById("nhomKsDropdown");
            const nhomKsInput = document.getElementById("nhomKsInput");
            const selectedNhomKs = document.getElementById("selected-nhom-ks");

            const existingDefaultOption = document.querySelector(
                `#list-nhomks-option .nhomks-option[data-value="${defaultNhomKsValue}"]`
            );

            if (existingDefaultOption) {
                selectedNhomKs.textContent = existingDefaultOption.textContent;
                selectedNhomKs.value = existingDefaultOption.dataset.value;
            }

            const nhomOptions = document.querySelectorAll(".nhomks-option");

            selectNhomKsBox.addEventListener("click", () => {
                nhomKsDropdown.classList.toggle("hidden");
                nhomKsInput.value = "";
                filterOptions("");
            });


            nhomKsInput.addEventListener("input", (e) => {
                filterOptions(e.target.value);
            });

            function filterOptions(query) {
                nhomOptions.forEach((option) => {
                    if (option.textContent.toLowerCase().includes(query.toLowerCase())) {
                        option.style.display = "block";
                    } else {
                        option.style.display = "none";
                    }
                });
            }

            // Close nhomKsDropdown when clicking outside
            document.addEventListener("click", (e) => {
                if (
                    !selectNhomKsBox.contains(e.target) &&
                    !nhomKsDropdown.contains(e.target)
                ) {
                    nhomKsDropdown.classList.add("hidden");
                }
            });
            //xu lý thêm nội dung
            const surveyContainer = document.getElementById("survey-container");
            loadSurveyContent(surveyContent, surveyContainer);
            console.log("detail,", surveyContent)



            $("#btn-update-used-survey-status").on("click", function () {
                const suDungStatus = $("#select-su-dung").val();
                if (updateTrangThaiSuDungKhaoSat(currentKsId, suDungStatus)) {
                    alert("Cập nhật trạng thái sử dụng thành công");
                } else {
                    alert("Cập nhật trạng thái sử dụng thất bại");
                }
            });
        })();
        /// btn xu ly cap nhat trang thai


        async function updateTrangThaiSuDungKhaoSat(ksId, suDungStatus) {
            console.log("thong update ", ksId, suDungStatus)
            try {
                const response = await $.ajax({
                    url: "./controller/KhaoSatController.php",
                    type: "POST",
                    data: {
                        func: "updateTrangThaiSuDungKhaoSat",
                        "ks-id": ksId,
                        "su-dung-status": suDungStatus
                    },
                    dataType: "json",
                });
                if (response.status == "error") {
                    console.log(response.message);
                    return false
                } else {
                    console.log(response)
                }
                return true;
            } catch (error) {
                console.log(error);
                console.log("lỗi cập nhật tình trạng sử dụng khảo sát");
                return false;
            }
        }

    });

    function createSection(sectionData = {}, isSubsection = false, readonly = true) {
        const section = document.createElement("div");
        section.classList.add("mb-4", "border", "border-gray-300", "p-4", "section");
        if (isSubsection) section.classList.add("ml-4");

        const sectionTitle = document.createElement("h3");
        sectionTitle.textContent = isSubsection ? "Tên mục con:" : "Tên mục:";
        section.appendChild(sectionTitle);

        const sectionNameInput = document.createElement("input");
        sectionNameInput.placeholder = "Nhập tên mục";
        sectionNameInput.classList.add("input", "mb-4");
        sectionNameInput.value = sectionData.ten_muc || "";
        if (readonly) sectionNameInput.setAttribute("readonly", true);
        section.appendChild(sectionNameInput);

        const questionContainer = document.createElement("div");
        questionContainer.classList.add("question-container");
        section.appendChild(questionContainer);

        const subSectionContainer = document.createElement("div");
        subSectionContainer.classList.add("sub-section-container");
        section.appendChild(subSectionContainer);

        if (!readonly) {
            const btnAddQuestion = document.createElement("button");
            btnAddQuestion.textContent = "Thêm câu hỏi";
            btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm", "mr-2");
            btnAddQuestion.addEventListener("click", () => {
                createQuestion(questionContainer, "", readonly);
                btnAddSubSection.style.display = "none";
            });
            section.appendChild(btnAddQuestion);

            const btnAddSubSection = document.createElement("button");
            btnAddSubSection.textContent = "Thêm mục con";
            btnAddSubSection.classList.add("btn", "btn-secondary", "btn-sm", "mr-2");
            btnAddSubSection.addEventListener("click", () => {
                const subSec = createSection({}, true, readonly);
                subSectionContainer.appendChild(subSec);
                btnAddQuestion.style.display = "none";
            });
            if (isSubsection) {
                btnAddSubSection.style.display = "none";
            }
            section.appendChild(btnAddSubSection);

            const deleteSectionButton = document.createElement("button");
            deleteSectionButton.textContent = isSubsection ? "Xóa mục" : "Xóa mục cha";
            deleteSectionButton.classList.add("btn", "btn-error", "btn-sm");
            deleteSectionButton.addEventListener("click", () => {
                const parentSection = section.parentElement.closest(".section");
                section.remove();

                if (isSubsection && parentSection) {
                    const remainingSub = parentSection.querySelectorAll(
                        ":scope > .sub-section-container > .section"
                    );
                    if (remainingSub.length === 0) {
                        const btnAddQuestion =
                            parentSection.querySelector("button.btn-primary");
                        if (btnAddQuestion) btnAddQuestion.style.display = "inline-block";
                    }
                }
            });

            section.appendChild(deleteSectionButton);
        }

        if (sectionData.cau_hoi && sectionData.cau_hoi.length > 0) {
            sectionData.cau_hoi.forEach((questionData) => {
                createQuestion(questionContainer, questionData.noi_dung, readonly);
            });
        }

        return section;
    }

    function createQuestion(questionContainer, questionText = "", readonly = true) {
        const question = document.createElement("div");
        question.classList.add("question-item", "flex-row", "flex", "items-center", "gap-4", "mb-4");

        const input = document.createElement("input");
        input.type = "text";
        input.classList.add("questionInput", "input", "w-s");
        input.value = questionText;
        if (readonly) input.setAttribute("readonly", true);

        const label = document.createElement("label");
        label.classList.add("label-text", "text-nowrap");
        label.textContent = "Câu hỏi:";

        question.appendChild(label);
        question.appendChild(input);

        if (!readonly) {
            const deleteQuestionButton = document.createElement("button");
            deleteQuestionButton.classList.add("deleteQuestion", "btn", "btn-square", "btn-outline", "btn-error");
            deleteQuestionButton.innerHTML = `<span class="icon-[tabler--x]">X</span>`;

            deleteQuestionButton.addEventListener("click", () => {
                question.remove();
                const section = questionContainer.closest(".section");
                const questionItems = section.querySelectorAll(".question-item");
                const isSubSection = section.classList.contains("ml-4");
                if (!isSubSection && questionItems.length === 0) {
                    const buttons = section.querySelectorAll("button");
                    buttons.forEach((btn) => {
                        if (btn.textContent.trim() === "Thêm mục con") {
                            btn.style.display = "inline-block";
                        }
                    });
                }
            });

            question.appendChild(deleteQuestionButton);
        }

        questionContainer.appendChild(question);
    }


    function loadSurveyContent(data, container) {
        if (data == null) { console.log('data null'); return; }
        data.forEach((sectionData) => {
            const sectionEl = createSection(
                {
                    ten_muc: sectionData.sectionName,
                    cau_hoi: (sectionData.questions || []).map((q) => ({
                        noi_dung: q.questionContent,
                    })),
                },
                false
            );

            if (sectionData.subSections && sectionData.subSections.length > 0) {
                const subContainer = sectionEl.querySelector(".sub-section-container");
                sectionData.subSections.forEach((subSectionData) => {
                    const subEl = createSection(
                        {
                            ten_muc: subSectionData.sectionName,
                            cau_hoi: (subSectionData.questions || []).map((q) => ({
                                noi_dung: q.questionContent,
                            })),
                        },
                        true
                    );
                    subContainer.appendChild(subEl);
                });
            }
            container.appendChild(sectionEl);
        });
    }
</script>