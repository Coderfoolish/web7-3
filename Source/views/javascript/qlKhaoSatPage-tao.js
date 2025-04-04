async function getNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "GET",
      data: { func: "getAllNhomKs" },
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
      data: { func: "getAllNganh" },
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
      data: { func: "getAllChuKi" },
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
      data: { func: "getAllTraLoi" },
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
$(function () {
  window.HSStaticMethods.autoInit();
  (async () => {
    const searchNhomKsInput = document.getElementById("search-nhom-ks");
    const nhomKsList = await getNhomKs();
    const nganhList = await getAllNganh();
    const chuKiList = await getAllChuKi();
    const answerTypeList = await getAllTraLoi();

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
        $("#select-nganh").append(
          `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
        );
      });
    }
    if (chuKiList != null) {
      chuKiList.map((item) => {
        $("#select-chu-ki").append(
          `<option value='${item.ck_id}'>${item.ten_ck}</option>`
        );
      });
    }
    if (answerTypeList != null) {
      answerTypeList.map((item) => {
        $("#select-loai-tra-loi").append(
          `<option value='${item.ltl_id}'>${item.thang_diem}</option>`
        );
      });
    }

    // xu ly select search nhom khao sat
    const selectNhomKsBox = document.getElementById("select-nhomks-box");
    const nhomKsDropdown = document.getElementById("nhomKsDropdown");
    const nhomKsInput = document.getElementById("nhomKsInput");
    const nhomOptions = document.querySelectorAll(".nhomks-option");
    const selectedNhomKs = document.getElementById("selected-option");

    selectNhomKsBox.addEventListener("click", () => {
      nhomKsDropdown.classList.toggle("hidden");
      nhomKsInput.value = ""; // Clear search input when nhomKsDropdown opens
      filterOptions("");
    });

    nhomOptions.forEach((option) => {
      option.addEventListener("click", () => {
        selectedNhomKs.textContent = option.textContent;
        selectedNhomKs.value = option.dataset.value;
        nhomKsDropdown.classList.toggle("hidden");
      });
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

    // xua li tao bai noi dung khao sat
    const survey = document.getElementById("survey-container");
    const btnAddSection = document.getElementById("btn-add-question");
    const submitSurveyButton = document.getElementById("btn-save-ks");

    btnAddSection.addEventListener("click", () => {
      const section = document.createElement("div");
      section.classList.add("mb-4", "border", "border-gray-300", "p-8");
      section.classList.add("section");

      const sectionTitle = document.createElement("h3");
      sectionTitle.textContent = "Tên mục:";
      section.appendChild(sectionTitle);

      const sectionNameInput = document.createElement("input");
      sectionNameInput.placeholder = "Nhập tên mục";
      sectionNameInput.classList.add("input", "mb-4");
      section.appendChild(sectionNameInput);

      // sectionNameInput.addEventListener("input", () => {
      //   sectionTitle.textContent =
      //     sectionNameInput.value || `Section ${survey.children.length + 1}`;
      // });

      const questionContainer = document.createElement("div");
      questionContainer.classList.add("question-container");
      section.appendChild(questionContainer);

      const btnAddQuestion = document.createElement("button");
      btnAddQuestion.textContent = "Thêm câu hỏi";
      btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm");
      btnAddQuestion.addEventListener("click", () => {
        const question = document.createElement("div");
        question.classList.add(
          "question-item",
          "flex-row",
          "flex",
          "items-center",
          "gap-4",
          "mb-4"
        );
        question.innerHTML = `
                  <label class="label-text text-nowrap">Câu hỏi:</label>
                  <input type="text" class="questionInput input w-s"/>
                  <button class="deleteQuestion btn btn-square btn-outline btn-error">
                  <span class="icon-[tabler--x]"></span>
                  </button>
              `;
        questionContainer.appendChild(question);

        const deleteQuestionButton = question.querySelector(".deleteQuestion");
        deleteQuestionButton.addEventListener("click", () => {
          question.remove();
        });
      });
      section.appendChild(btnAddQuestion);

      const deleteSectionButton = document.createElement("button");
      deleteSectionButton.textContent = "Xóa mục";
      deleteSectionButton.classList.add(
        "btn",
        "btn-error",
        "ml-[10px]",
        "btn-sm"
      );
      deleteSectionButton.addEventListener("click", () => {
        section.remove();
      });
      section.appendChild(deleteSectionButton);

      survey.appendChild(section);
    });

    //xu ly submit
    submitSurveyButton.addEventListener("click", () => {
      const surveyData = [];
      const sections = survey.querySelectorAll(".section");

      const sa = selectedNhomKs.value;

      console.log(sa);
      sections.forEach((section, sectionIndex) => {
        const sectionName = section.querySelector("input").value;
        const questions = [];
        const questionElements = section.querySelectorAll(".question-item");

        questionElements.forEach((questionElement) => {
          const questionInput =
            questionElement.querySelector(".questionInput").value;
          questions.push(questionInput);
        });

        surveyData.push({
          sectionName: sectionName,
          questions: questions,
        });
      });

      console.log(JSON.stringify(surveyData, null, 2));
    });
  })();
});
