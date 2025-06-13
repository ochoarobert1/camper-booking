document.addEventListener("DOMContentLoaded", function () {
  // Date picker localization
  const dateLang = {
      days: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
      months: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      monthsShort: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      today: "Today",
      clear: "Clear",
      dateFormat: "MM/dd/yyyy",
      timeFormat: "hh:ii aa",
      firstDay: 0,
    },
    allCampers = document.querySelectorAll(".camper-radio-item");

  if (allCampers) {
    allCampers.forEach((camper) => {
      camper.addEventListener("click", function (e) {
        // Remove selected class from all campers
        allCampers.forEach((item) => {
          item.classList.remove("selected");
        });
        // Add selected class to the clicked camper (this)
        this.classList.add("selected");
      });
    });
  }

  // Handle step navigation
  function handleStepNavigation(e, direction) {
    e.preventDefault();
    const currentStep = parseInt(e.target.getAttribute("data-step"));
    const targetStep =
      direction === "next"
        ? currentStep + 1
        : currentStep > 1
        ? currentStep - 1
        : 1;

    // Validate current step before proceeding
    if (!validateStep(currentStep) && direction === "next") {
      // Show error message if validation fails
      return false;
    }

    const currentElement = document.querySelector(`#formStep${currentStep}`);
    const targetElement = document.querySelector(`#formStep${targetStep}`);
    setActiveBookingStep(targetStep - 1);

    if (targetElement) {
      currentElement.classList.add("hidden");
      targetElement.classList.remove("hidden");
    }
  }

  function validateStep(step) {
    let isValid = true;
    const currentForm = document.querySelector(`#formStep${step}`);

    // Step-specific validations
    if (step === 1) {
      // Validate date selection
      const startDateInput = document.querySelector("#startDate");
      const endDateInput = document.querySelector("#endDate");

      if (!startDateInput.value.trim()) {
        startDateInput.classList.add("error");
        document.querySelector("#errorDate1").classList.remove("hidden");
        isValid = false;
      } else {
        startDateInput.classList.remove("error");
        document.querySelector("#errorDate1").classList.add("hidden");
      }

      if (!endDateInput.value.trim()) {
        endDateInput.classList.add("error");
        document.querySelector("#errorDate2").classList.remove("hidden");
        isValid = false;
      } else {
        endDateInput.classList.remove("error");
        document.querySelector("#errorDate2").classList.add("hidden");
      }

      if (isValid) {
        const formattedDates =
          startDateInput.value + " - " + endDateInput.value;
        fillStepsInfo(
          {
            dates: formattedDates,
            days: document.querySelector("#daysSelected").value,
          },
          1
        );
      }
    } else if (step === 2) {
      // Validate personal information fields
      const nameInput = document.querySelector("#name");
      const emailInput = document.querySelector("#email");
      const phoneInput = document.querySelector("#phone");

      // Name validation
      if (!nameInput.value.trim()) {
        nameInput.classList.add("error");
        isValid = false;
      } else {
        nameInput.classList.remove("error");
      }

      // Email validation with regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (
        !emailInput.value.trim() ||
        !emailRegex.test(emailInput.value.trim())
      ) {
        emailInput.classList.add("error");
        isValid = false;
      } else {
        emailInput.classList.remove("error");
      }

      // Phone validation - basic check for now
      if (!phoneInput.value.trim() || phoneInput.value.trim().length < 6) {
        phoneInput.classList.add("error");
        isValid = false;
      } else {
        phoneInput.classList.remove("error");
      }

      // Update personal info in sidebar if valid
      if (isValid) {
        document.querySelector(
          "#personalInfo"
        ).innerHTML = `<strong>Name:</strong> ${nameInput.value}<br>
           <strong>Email:</strong> ${emailInput.value}<br>
           <strong>Phone:</strong> ${phoneInput.value}`;
        document.querySelector("#errorStep2").classList.add("hidden");
        fillStepsInfo(
          {
            name: nameInput.value,
            email: emailInput.value,
            phone: phoneInput.value,
          },
          2
        );
      } else {
        document.querySelector("#errorStep2").classList.remove("hidden");
      }
    } else if (step === 3) {
      // Validate camper selection
      const camperSelected = document.querySelector(
        'input[name="camper"]:checked'
      );

      if (!camperSelected) {
        isValid = false;
        document.querySelector("#errorStep3").classList.remove("hidden");
      } else {
        document.querySelector("#errorStep3").classList.add("hidden");

        // Update camper selection in sidebar
        const camperLabel = document.querySelector(
          `label[for="${camperSelected.id}"] span`
        ).textContent;
        document.querySelector(
          "#camperSelection"
        ).innerHTML = `<strong>Selected Camper:</strong> ${camperLabel}`;

        calculateTotalPrice(
          camperSelected.getAttribute("data-camper-price"),
          document.querySelector("#daysSelected").value
        );

        fillStepsInfo(
          {
            camperName: camperSelected.getAttribute("data-camper-name"),
            camperPrice: camperSelected.getAttribute("data-camper-price"),
            totalPrice: document.querySelector("#total").value,
          },
          3
        );
      }
    }

    // General validation for all required fields
    const requiredFields = currentForm.querySelectorAll("[required]");
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        field.classList.add("error");
        isValid = false;
      } else {
        field.classList.remove("error");
      }
    });

    // Show error message if validation fails
    const errorMsg = currentForm.querySelector(".validation-error");
    if (errorMsg) {
      errorMsg.style.display = isValid ? "none" : "block";
    }

    return isValid;
  }

  function setActiveBookingStep(stepIndex) {
    const steps = document.querySelectorAll(".camper-booking-step-item");
    steps.forEach((step, idx) => {
      if (idx === stepIndex) {
        step.classList.add("active");
      } else {
        step.classList.remove("active");
      }
    });
  }

  function fillStepsInfo(data, stepIndex) {
    switch (stepIndex) {
      case 1:
        document.querySelector("#selectedDates").innerHTML = data.dates;
        document.querySelector("#selectedDays").innerHTML = data.days;
        document.querySelector("#camperDates").innerHTML =
          data.dates + " (" + data.days + " days)";
        break;
      case 2:
        document.querySelector("#selectedName").innerHTML = data.name;
        document.querySelector("#selectedEmail").innerHTML = data.email;
        document.querySelector("#selectedPhone").innerHTML = data.phone;
        break;
      case 3:
        document.querySelector("#camperDescription").innerHTML =
          data.camperName;
        document.querySelector("#camperPrice").innerHTML =
          "$ " + parseFloat(data.camperPrice).toFixed(2);
        document.querySelector("#totalPrice").innerHTML =
          "$ " + data.totalPrice;
        break;
    }
  }

  function calculateTotalPrice(camperPrice, days) {
    const totalPrice = parseFloat(camperPrice) * parseInt(days);
    document.querySelector("#total").value = totalPrice.toFixed(2);
    document.querySelector("#totalPrice").innerHTML =
      "$ " + totalPrice.toFixed(2);
  }

  function processBooking() {
    // Create XHR request
    let formData = new FormData(document.getElementById("camperBookingForm")),
      xhr = new XMLHttpRequest();

    formData.append("action", "camper_booking");
    formData.append("nonce", camperBooking.nonce);

    xhr.open("POST", camperBooking.ajaxUrl, true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        window.location.href = camperBooking.thanksUrl;
      } else {
        console.error("Request failed: " + xhr.status);
      }
    };

    xhr.onerror = function () {
      console.error("Request failed");
    };

    xhr.send(formData);
  }

  // Add event listeners to navigation buttons
  document.querySelectorAll("button.next-step").forEach((btn) => {
    btn.addEventListener("click", (e) => handleStepNavigation(e, "next"));
  });

  document.querySelectorAll("button.prev-step").forEach((btn) => {
    btn.addEventListener("click", (e) => handleStepNavigation(e, "prev"));
  });
  // Parse date string to Date object
  function parseDate(dateStr) {
    const parts = dateStr.trim().split("/");
    return new Date(
      parseInt(parts[2], 10),
      parseInt(parts[1], 10) - 1,
      parseInt(parts[0], 10)
    );
  }

  // Initialize date pickers
  let endDatePicker, startDatePicker;

  startDatePicker = new AirDatepicker("#startDate", {
    range: false,
    minDate: new Date(),
    locale: dateLang,
    dateFormat: "dd/MM/yyyy",
    buttons: ["today", "clear"],
    autoClose: true,
    onSelect: function (date) {
      if (date.date) {
        const nextDay = new Date(date.date);
        nextDay.setDate(nextDay.getDate() + 1);
        endDatePicker.update({
          minDate: nextDay,
        });
        calculateDays();
      }
    },
  });

  endDatePicker = new AirDatepicker("#endDate", {
    range: false,
    minDate: new Date(),
    locale: dateLang,
    dateFormat: "dd/MM/yyyy",
    buttons: ["today", "clear"],
    autoClose: true,
    onSelect: function (date) {
      calculateDays();
    },
  });

  // Calculate days between selected dates
  // Convert date from dd/MM/yyyy to yyyy-MM-ddTHH:mm:ss format
  function formatDateToDateTime(dateStr) {
    if (!dateStr) return "";
    const parts = dateStr.trim().split("/");
    return `${parts[2]}-${parts[1]}-${parts[0]}T10:00:00`;
  }

  function calculateDays() {
    const startDateInput = document.querySelector("#startDate");
    const endDateInput = document.querySelector("#endDate");

    if (!startDateInput.value || !endDateInput.value) return;

    const startDateStr = startDateInput.value.trim();
    const endDateStr = endDateInput.value.trim();

    // Convert to datetime format
    const startDateTime = formatDateToDateTime(startDateStr);
    const endDateTime = formatDateToDateTime(endDateStr);

    // Store formatted dates in hidden fields if they exist
    if (document.querySelector("#startDateTime")) {
      document.querySelector("#startDateTime").value = startDateTime;
    }
    if (document.querySelector("#endDateTime")) {
      document.querySelector("#endDateTime").value = endDateTime;
    }

    const date1 = parseDate(startDateStr);
    const date2 = parseDate(endDateStr);

    // Update UI with selected dates
    document.querySelector("#bookingDates").innerHTML =
      "<strong>Selected Dates:</strong> " + startDateStr + " - " + endDateStr;

    // Calculate and display duration
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

    document.querySelector("#daysSelected").value = diffDays;

    document.querySelector("#bookingDays").innerHTML =
      "<strong>Days Quantity:</strong> " + diffDays + " days";
  }

  if (document.querySelector(".make-payment")) {
    document
      .querySelector(".make-payment")
      .addEventListener("click", function (e) {
        e.preventDefault();
        if (validateStep(3)) {
          processBooking();
        } else {
          alert("Please complete all required fields before proceeding.");
        }
      });
  }
});
