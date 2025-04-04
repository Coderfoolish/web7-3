<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Tạo bài khảo sát</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="pt-0 mb-4">
            <div class="mb-2">
                <label class="label-text" for="fullName"> Tên bài khảo sát </label>
                <input type="text" placeholder="John Doe" class="input" id="fullName" />
            </div>
            <div class="relative max-w-sm">
            <label class="label-text" for="fullName"> Tên bài nhóm khảo sát </label>
                <div id="select-nhomks-box" class="border border-gray-300 rounded-md p-2 cursor-pointer bg-white">
                    <span id="selected-option">Chọn nhóm</span>
                </div>
                <div id="nhomKsDropdown"
                    class=" hidden absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                    <input type="text" id="nhomKsInput" placeholder="Chọn nhóm "
                        class="p-2 w-full border-b border-gray-300 focus:outline-none" />
                    <div id="list-nhomks-option" class="max-h-60 overflow-y-auto">
                    </div>
                </div>
            </div>
            <div class="mb-0.5 flex gap-4 max-sm:flex-col">
                <div class="w-full">
                    <label class="label-text" for="begin"> Bắt đầu </label>
                    <input type="date" class="input" id="begin" />
                </div>
                <div class="w-full">
                    <label class="label-text" for="end"> Kết thúc</label>
                    <input type="date" class="input" id="end" />
                </div>
            </div>
        </div>
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="select-loai-tra-loi">Loại câu trả lời </label>
                <select class="select" id="select-loai-tra-loi">
                    <option>Chọn loại</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-nganh">Ngành </label>
                <select class="select" id="select-nganh">
                    <option>Chọn ngành</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-chu-ki">Chu kì</label>
                <select class="select" id="select-chu-ki">
                    <option>Chọn chu kì</option>
                </select>
            </div>
        </div>
    </div>
    <!-- cau hoi -->
    <div class="modal-body pt-0 mb-4">
        <p class="mb-4">
            Nội dung khảo sát
        </p>
        <div id="survey-container"></div>
        <button id="btn-add-question" class="btn btn-primary mb-4">Tạo mục câu hỏi</button>

    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save-ks" type="submit" class="btn btn-primary">Lưu</button>
    </div>
</div>
<script src="views/javascript/qlKhaoSatPage-tao.js"></script>