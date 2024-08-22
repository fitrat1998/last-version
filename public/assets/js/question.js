$(document).ready(() => {
    // get elements
    const questionContent = document.querySelector("#questionContent");
    const questionPaginPrev = document.querySelector("#questionPaginPrev");
    const questionPaginNext = document.querySelector("#questionPaginNext");
    const questionPrevLabel = document.querySelector("#questionPrevLabel");
    const questionCurrentLabel = document.querySelector("#questionCurrentLabel");
    const questionNextLabel = document.querySelector("#questionNextLabel");
    const quesCard = document.querySelector("#questionCard");
    const variantListForm = document.querySelector("#variantListForm");
    const examTestMenuBtn = document.querySelector("#examTestMenuBtn");

    /* ================================ /
              CONFIG VARIABLES
     ==================================*/
    //  exmap id
    const currentExampUrl = $("#examUrl").attr("data-check-url");
    // local storage name
    const localStorageName = "questionlocaldatatamp";
    // variant input
    const variantInputQuesKey = "data-question-key";
    // navigate succes route
    const navigateSuccessRoute = "../";


    /* ====================Toggle test menu========================= */
    // examTestMenuBtn.on('click',() => {
    //     alert("menu")
    // })

    examTestMenuBtn.addEventListener('click', () => {
        $('#examTestMenu').toggleClass('show');
    })
    $('#examTestMenu').on('click', () => {
        $('#examTestMenu').removeClass('show');
    });
    $('#questionContent').on('click', () => {
        $('#examTestMenu').removeClass('show');
    });

    var confirmed = false;

    window.onbeforeunload = function (e) {
        e = e || window.event;
        if (!confirmed) {
            e.returnValue = "Are you sure you want to close?";
            confirmed = true;
            handleSubmit();
        }
    };


    var timerElement = document.getElementById('timer');
    if (timerElement) {
        var timeText = timerElement.textContent.trim();
        console.log('Initial time:', timeText); // Boshlang'ich vaqtni tekshirish

        var timeParts = timeText.split(':');

        // Soat, minut va sekundlarni ajratib olish
        var hours = parseInt(timeParts, 10);
        var minutes = parseInt(timeParts[1], 10);
        var seconds = parseInt(timeParts[2], 10);

        var hours_old = parseInt(timeParts[0], 10);

        // NaN bo'lishidan ehtiyot bo'ling
        if (isNaN(hours)) hours = 0;
        if (isNaN(minutes)) minutes = 0;
        if (isNaN(seconds)) seconds = 0;

        // Agar soatlar 0 dan kichik bo'lsa, to'g'ri qiymatni saqlash
        if (hours < 1 && hours >= 0 && minutes >= 0 && seconds >= 0) {
            hours = hours_old; // Boshlang'ich vaqtni 01:20:56 qilib qo'yish
        }

        function startTimer() {
            var timerInterval = setInterval(function () {
                // Sekundlarni kamaytirish
                if (seconds > 0) {
                    seconds--;
                } else {
                    if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else {
                        if (hours > 0) {
                            hours--;
                            minutes = 59;
                            seconds = 59;
                        } else {
                            clearInterval(timerInterval);
                            handleSubmit();
                        }
                    }
                }

                // Raqamlarni ikki raqamli formatda ko'rsatish
                var hoursLeft = hours < 10 ? '0' + hours : hours;
                var minutesLeft = minutes < 10 ? '0' + minutes : minutes;
                var secondsLeft = seconds < 10 ? '0' + seconds : seconds;

                console.log('Current time:', hoursLeft + ':' + minutesLeft + ':' + secondsLeft);

                timerElement.innerHTML = hoursLeft + ':' + minutesLeft + ':' + secondsLeft;
            }, 1000);
        }

        startTimer();
    } else {
        console.error('Timer element not found!');
    }

    /* ====================Get data========================= */
    function getData() {
        const originalData = getOriginalQuesFromLocal();
        // console.log("submited data", originalData);
        if (originalData && originalData.length) {
            startQuiz([...originalData])
            return;
        }

        $.ajax({
            url: currentExampUrl,
            method: "get",
            success: function (data) {
                if (data && data?.length) {
                    setOriginalQuesToLocal([...data])
                    startQuiz([...data]);
                }
            },
        });
    }

    getData()

    /* ====================Submit========================= */
    const handleSubmit = () => {
        // submit data
        const localData = getDataFromLocal();
        $.ajax({
            url: currentExampUrl + '/result',
            method: "GET",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                data: localData
            },
            success: function (x) {
                console.log(x);
                // return;
                if (x) {
                    // LocalSetdan o'chirish
                    clearDataFromLocal()

                    // orqagan qaytarish

                    history.back()
                }
            }
        })

        // loading
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });

        // ajax

        // success message
        Toast.fire({
            icon: "success",
            title: "Muvaffaqiyatli yakunlandi",
        });

        // error message
        // Toast.fire({
        //   icon: "error",
        //   title: "Xatolik yuz berdi. Qaytadan tugatish tugmasini bosing!",
        // });

        //history.back()
    };

    function finish() {
        setTimeout(() => {
            window.location.href = navigateSuccessRoute;
        }, 1500);

        clearDataFromLocal();
    }

    /* ============================Submit btn==================================== */
    $("#questionSubmitBtn").click(function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Tugatish?",
            text: "Siz testni tugatmoqchimisiz!",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ha albatta!",
            cancelButtonText: "Yo'q",
        }).then((result) => {
            if (result.isConfirmed) {
                handleSubmit();
            }
        });
    });

    /* ================================ /
              START
     ==================================*/
    function startQuiz(data = []) {
        const activeQuesItem = getActiveQuesItem(data);

        // btns
        const createdBtns = [];
        // create btns
        data.map((item) =>
            createdBtns.push(
                createBtn(data, createdBtns, {
                    quesId: item.id,
                    quesIndex: item.questionIndex,
                    isActive:
                        !activeQuesItem && item?.questionIndex?.toString() === "1",
                })
            )
        );
        setToList(createdBtns);

        // initial card
        if (activeQuesItem) {
            const {id, question, image, variants, multipleSelect} = activeQuesItem;
            createCard({
                questionId: id,
                image,
                isMultiple: multipleSelect,
                title: question,
                variants: {...variants},
            });
        } else {
            const firstQuesItem = data[0];
            if (firstQuesItem) {
                const {id, question, image, variants, multipleSelect} = firstQuesItem;
                createCard({
                    questionId: id,
                    image,
                    isMultiple: multipleSelect,
                    title: question,
                    variants: {...variants},
                });
            }
        }

        // variant inputs changed listerner
        formListEventListerner(data);
    }

    /* ====================Create btns========================= */
    function createBtn(
        questionsData,
        prevBtns,
        {quesId, quesIndex, isActive = false}
    ) {
        // class name
        let className = "question__list--btn";

        const activeQuesId = getActiveQuesId();
        if (activeQuesId === quesId.toString() || isActive) className += " active";

        // button
        const btn = document.createElement("button");
        btn.setAttribute("data-ques-id", quesId);
        btn.className = className;
        btn.textContent = quesIndex;

        // get selected item
        const selectedItem = getSelectedItem(quesId);
        if (selectedItem && selectedItem?.variantList) {
            const res = Object.keys(selectedItem?.variantList).find(
                (key) => selectedItem?.variantList[key]
            );
            if (res) {
                btn.classList.add("selected");
            }
        }

        // action
        btn.addEventListener("click", () => {
            // clear active
            prevBtns.map((item) => {
                item.classList.remove("active");
            });

            // set active
            if (setActiveQues(quesId)) {
                btn.classList.add("active");
            }

            // set data to card
            const cardData = questionsData.find(
                (item) => item.id.toString() === quesId?.toString()
            );
            if (cardData) {
                const {id, question, image, variants, multipleSelect} = cardData;
                quesCard.innerHTML = "";
                variantListForm.innerHTML = "";

                createCard({
                    questionId: id,
                    image,
                    isMultiple: multipleSelect,
                    title: question,
                    variants: {...variants},
                });
            }
        });

        return btn;
    }

    // Set to list
    function setToList(btnsList = []) {
        btnsList.map((item) => {
            $(".question__list").append(item);
        });
    }

    /* ====================Card quesiton========================= */
    function createCard({questionId, title, image, variants, isMultiple}) {
        // set image
        setImage(image);

        // set title
        setTitle(title);

        // set variants
        setVariantsData({
            questionId,
            variants: variants,
            isMultiple,
        });
    }

    // card image
    function setImage(url) {
        if (!url) return;

        // create image
        const img = document.createElement("img");
        img.src = url;
        img.className = "card-img-top";
        img.alt = "Question";

        // set image to card
        quesCard.append(img);
    }

    // card title
    function setTitle(title) {
        if (!title) return;

        // create title
        const div = document.createElement("div");
        div.className = "card-body";
        div.textContent = title;

        // set title to card
        quesCard.append(div);
    }

    // card variants list
    function setVariantsData({questionId, variants = [], isMultiple = false}) {
        // check
        if (!variants) {
            alert("Variants required");
            throw new Error("Variants required");
        }

        // get selected item
        const selectedItem = getSelectedItem(questionId);
        // const selectedItem = null;

        if (selectedItem && selectedItem?.variantList) {
            // create variant inputs
            Object.keys(variants).map((key) => {
                const isChecked = selectedItem?.variantList[key];

                setVariant({
                    variant: key,
                    title: variants[key],
                    questionId,
                    isMultiple: false,
                    isChecked,
                });
            });
        } else {
            // create variant inputs
            Object.keys(variants).map((key) => {
                setVariant({
                    variant: key,
                    title: variants[key],
                    questionId,
                    isMultiple: false,
                });
            });
        }
    }

    // card variant
    function setVariant({
                            variant,
                            title,
                            questionId,
                            isMultiple = false,
                            isChecked = false,
                        }) {
        // label
        const label = document.createElement("label");
        label.setAttribute("for", variant);
        label.className = "variant--card notSelect";

        // input
        const input = document.createElement("input");
        input.type = !isMultiple ? "radio" : "checkbox";
        input.id = variant;
        input.name = "variant";
        input.checked = isChecked;
        input.setAttribute(variantInputQuesKey, questionId);

        label.append(input);

        // inner
        const innerdiv = document.createElement("div");
        innerdiv.className = "varinat--card__inner";

        // h1
        const h1 = document.createElement("h1");
        h1.className = "varinat__title";
        h1.textContent = `${variant})`;
        innerdiv.append(h1);

        // p
        const p = (document.createElement("p").textContent = title);
        innerdiv.append(p);

        // inner set to label
        label.append(innerdiv);

        // label set to variants
        variantListForm.append(label);
    }

    /* ============================FORM ACTION LISTERNER==================================== */
    function formListEventListerner(questionItemList = []) {
        variantListForm.addEventListener("change", (e) => {
            const {id, checked, type} = e.target;
            const questionId = e.target.getAttribute(variantInputQuesKey);

            if (
                !questionItemList.find((item) => item?.id?.toString() === questionId)
            ) {
                throw new Error(`this "${questionId}" question is not found`);
            }

            if (type === "radio" || type === "checkbox") {
                setDataToLocal({
                    questionId,
                    value: checked,
                    variant: id,
                    isMultiple: type === "checkbox",
                });

                // get selected item
                const selectedItem = getSelectedItem(questionId);
                // set selected to btn
                if (selectedItem && selectedItem?.variantList) {
                    const res = Object.keys(selectedItem?.variantList).find(
                        (key) => selectedItem?.variantList[key]
                    );
                    if (res) {
                        $('[data-ques-id="' + questionId + '"]').addClass("selected");
                    } else {
                        $('[data-ques-id="' + questionId + '"]').removeClass("selected");
                    }
                }
            } else {
                throw new Error(`Input type incorrect: ${id}- ${type}`);
            }
        });
    }

    /* ====================Other actions========================= */

    // get active question item
    function getActiveQuesItem(data) {
        // active question
        const activeQuesId = getActiveQuesId();

        if (activeQuesId) {
            return data.find(
                (item) => item.id.toString() === activeQuesId?.toString()
            );
        }
        return null;
    }

    // update object value of array
    function updateObjectValue(array, id, newValue, edit = false) {
        const index = array.findIndex((obj) => obj?.questionId === id);

        if (index !== -1) {
            if (edit) {
                const previousValue = array[index].variantList;

                array[index].variantList = {
                    ...previousValue,
                    ...newValue,
                };
            } else {
                array[index].variantList = {
                    ...newValue,
                };
            }

            return array;
        }

        return array;
    }

    // get selected question from local storage
    function getSelectedItem(questionId) {
        // local data
        let localData = getDataFromLocal();

        return localData.find(
            (locItem) => locItem?.questionId.toString() === questionId.toString()
        );
    }

    /* ====================Local Storage========================= */

    // set active ques
    function setActiveQues(quesId) {
        if (!quesId) {
            throw new Error("`quesId` requeired");
        }

        // local storage
        localStorage.setItem("activeQues", quesId);
        return true;
    }

    // get active ques
    function getActiveQuesId() {
        // local storage
        return localStorage.getItem("activeQues");
    }

    // set all selected data
    function setDataToLocal({questionId, variant, value, isMultiple}) {
        // check
        if (!questionId) throw new Error("Question `questionId` is required");
        if (!variant) throw new Error("`variant` is required");

        // data
        let localData = getDataFromLocal();

        if (localData.find((item) => item?.questionId?.toString() === questionId)) {
            if (isMultiple) {
                localData = updateObjectValue(
                    localData,
                    questionId,
                    {
                        [variant]: value,
                    },
                    true
                );
            } else {
                localData = updateObjectValue(localData, questionId, {
                    [variant]: value,
                });
            }
        } else {

            localData.push({
                questionId,
                variantList: {[variant]: value},
            });
        }

        // local storage
        localStorage.setItem(localStorageName, JSON.stringify(localData));
    }

    // get all selected data
    function getDataFromLocal() {
        // local storage
        const data = localStorage.getItem(localStorageName);

        if (!data) return [];

        try {
            return JSON.parse(data);
        } catch (err) {
            console.error(err);
            clearDataFromLocal();
            alert(
                "Noma'lum texnik xatolik yuz berdi. Shuning uchun QAYTADAN BELGILASHingiz kerak!"
            );
            return [];
        }
    }

    function clearDataFromLocal() {
        // local storage
        localStorage.clear(localStorageName);
        localStorage.clear("activeQues");
        localStorage.clear("originalQues");
    }

    function setOriginalQuesToLocal(data) {
        // local storage
        localStorage.setItem('originalQues', JSON.stringify(data));
    }

    function getOriginalQuesFromLocal() {
        // local storage
        const data = localStorage.getItem('originalQues');

        if (!data) return [];

        try {
            return JSON.parse(data);
        } catch (err) {
            console.error(err);
            clearDataFromLocal();
            alert(
                "Noma'lum texnik xatolik yuz berdi. Shuning uchun QAYTADAN BELGILASHingiz kerak!"
            );
            return [];
        }
    }
});
