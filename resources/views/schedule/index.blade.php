<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Document</title>
          @vite('resources/css/app.css')
    </head>
    <body
        class="bg-gray-100 flex justify-center items-center w-screen h-screen"
    >
        <!-- Main Calendar Section -->
        <div class="flex justify-center h-max w-1/4 items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <button
                        id="prev"
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Prev
                    </button>
                    <h2 id="month-year" class="text-lg font-bold"></h2>
                    <button
                        id="next"
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Next
                    </button>
                </div>
                <table class="w-full table-fixed">
                    <thead>
                        <tr>
                            <th class="py-2">Sun</th>
                            <th class="py-2">Mon</th>
                            <th class="py-2">Tue</th>
                            <th class="py-2">Wed</th>
                            <th class="py-2">Thu</th>
                            <th class="py-2">Fri</th>
                            <th class="py-2">Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Calendar dates will be dynamically generated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Section -->
        <div
            id="modal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center"
        >
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-lg font-bold mb-4" id="modal-title">
                    Set Times for Date
                </h3>
                <div class="mb-4">
                    <label
                        for="opening-time"
                        class="block text-sm font-medium text-gray-700"
                        >Opening Time</label
                    >
                    <input
                        type="time"
                        id="opening-time"
                        class="mt-1 p-2 w-full border border-gray-300 rounded"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="closing-time"
                        class="block text-sm font-medium text-gray-700"
                        >Closing Time</label
                    >
                    <input
                        type="time"
                        id="closing-time"
                        class="mt-1 p-2 w-full border border-gray-300 rounded"
                    />
                </div>
                <div class="flex justify-end">
                    <button
                        id="close-modal"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                    >
                        Close
                    </button>
                    <button
                        id="save-time"
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>

        <script>
            const monthYearEl = document.getElementById("month-year");
            const calendarBody = document.getElementById("calendar-body");
            const prevBtn = document.getElementById("prev");
            const nextBtn = document.getElementById("next");
            const modal = document.getElementById("modal");
            const modalTitle = document.getElementById("modal-title");
            const closeModalBtn = document.getElementById("close-modal");
            const saveTimeBtn = document.getElementById("save-time");
            const openingTimeInput = document.getElementById("opening-time");
            const closingTimeInput = document.getElementById("closing-time");

            let currentDate = new Date();
            let selectedDate = null;

            // Update the calendar for the current month and year
            function updateCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Get the first day of the month
            const firstDayOfMonth = new Date(year, month, 1).getDay();

            // Get the number of days in the current month
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Clear previous calendar data
            calendarBody.innerHTML = "";

            // Update the month and year in the header
            const monthNames = [
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
            ];
            monthYearEl.textContent = `${monthNames[month]} ${year}`;

            // Create the rows and cells for the calendar
            let date = 1;
            for (let i = 0; i < 6; i++) {
                let row = document.createElement("tr");

                for (let j = 0; j < 7; j++) {
                let cell = document.createElement("td");
                cell.classList.add(
                    "text-center",
                    "py-2",
                    "border",
                    "border-gray-200",
                    "cursor-pointer"
                );

                if (i === 0 && j < firstDayOfMonth) {
                    cell.textContent = "";
                } else if (date > daysInMonth) {
                    break;
                } else {
                    cell.textContent = date;
                    cell.addEventListener("click", () =>
                    openModal(cell.textContent, month, year)
                    );
                    date++;
                }

                row.appendChild(cell);
                }

                calendarBody.appendChild(row);
            }
            }

            // Open modal function
            function openModal(day, month, year) {
                selectedDate = `${year}-${month + 1}-${day}`;
                modalTitle.textContent = `Set Times for ${day}/${month + 1}/${year}`;
                openingTimeInput.value = "";
                closingTimeInput.value = "";
                modal.classList.add("flex");
                modal.classList.remove("hidden");
            }

            // Close modal function
            closeModalBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });

            // Save opening and closing times
            saveTimeBtn.addEventListener("click", () => {
                const openingTime = openingTimeInput.value;
                const closingTime = closingTimeInput.value;
                if (openingTime && closingTime) {
                    fetch(`/api/schedule-store`, {
                        method:"POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            date: selectedDate,
                            opening_time: openingTime,
                            closing_time: closingTime,
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        alert("Opening and closing times saved successfully.");
                        modal.classList.add("hidden");
                    })
                    .catch((error) => {
                        console.error(error);
                        alert("An error occurred. Please try again. ",error?.message);
                    })
                } else {
                    alert("Please set both opening and closing times.");
                }
            });

            // Add event listeners for previous and next buttons
            prevBtn.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                    updateCalendar();
                });

                nextBtn.addEventListener("click", () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    updateCalendar();
            });

            // Initialize the calendar on page load
            updateCalendar();

        </script>
    </body>
</html>
