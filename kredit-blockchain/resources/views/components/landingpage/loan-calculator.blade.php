```php
<div class="w-full max-w-3xl">
    <form id="loan-calculator-form" action="{{ route('calculate.loan') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Loan Amount -->
        <div class="flex flex-col items-start hidden-animated">
            <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">1.</span> Jumlah Pinjaman yang akan diajukan</p>
            <p class="text-gray-500">Maksimal pengajuan pinjaman adalah <span><span class="text-red-500">Rp100.000.000</span></span></p>
            <div class="my-5 inline-flex w-[650px] h-[50px]">
                <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[400px] h-full pl-5">Jumlah Pinjaman</p>
                <p class="flex items-center border border-r-0 border-l-0 border-gray-300 w-[45px] h-full pl-5 text-[#1167B1] font-semibold">Rp.</p>
                <input type="number" name="loan_amount" id="loan_amount" min="1000000" max="100000000" step="100000"
                       class="flex border-l-0 rounded-r-lg w-[250px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" 
                       placeholder="Masukkan jumlah pinjaman" required>
                @error('loan_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Loan Duration -->
        <div class="flex flex-col items-start mt-5 hidden-animated">
            <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">2.</span> Lama Pinjaman yang Akan Diajukan</p>
            <p class="text-gray-500">Masukkan pinjaman dalam jangka waktu bulan.</p>
            <div class="my-5 inline-flex w-[650px] h-[50px]">
                <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Lama Pinjaman</p>
                <input type="number" name="loan_duration" id="loan_duration" min="1" step="1"
                       class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" 
                       placeholder="Masukkan Bulan" required>
                <p class="flex items-center justify-end border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5 text-[#2A9DF4] font-semibold">Bulan</p>
                @error('loan_duration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Interest Rate -->
        <div class="flex flex-col items-start mt-5 hidden-animated">
            <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">3.</span> Bunga Pinjaman</p>
            <p class="text-gray-500">Bunga pinjaman yang dimasukkan dalam kurun waktu per tahun.</p>
            <div class="my-5 inline-flex w-[650px] h-[50px]">
                <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Bunga Pinjaman</p>
                <input type="text" id="interest_rate" readonly
                       class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" 
                       placeholder="Otomatis">
                <p class="flex items-center justify-end text-[#2A9DF4] font-semibold border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5">%</p>
            </div>
        </div>

        <!-- Start and End Date -->
        <div class="flex flex-col items-start mt-5 hidden-animated">
            <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">4.</span> Mulai Melakukan Pinjaman</p>
            <p class="text-gray-500">Masukkan waktu Anda mulai melakukan peminjaman.</p>
            <div class="flex justify-between w-[650px] h-[50px]">
                <x-landingpage.option-month name="start_month"></x-landingpage.option-month>
                <x-landingpage.option-year name="start_year"></x-landingpage.option-year>
            </div>
            @error('start_month')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('start_year')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <p class="mt-10 font-bold text-[#1167B1] text-lg text-center w-full hidden-animated">Sampai Dengan</p>
            <div class="flex justify-between w-[650px] h-[50px] hidden-animated">
                <x-landingpage.option-month name="end_month"></x-landingpage.option-month>
                <x-landingpage.option-year name="end_year"></x-landingpage.option-year>
            </div>
            @error('end_month')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('end_year')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center mt-8 hidden-animated">
            <button type="submit"
                    class="px-10 py-4 bg-[#1167B1] text-white rounded-xl border transition ease-in-out hover:-translate-y-1 hover:scale-105">
                Hitung
            </button>
        </div>
    </form>

    <!-- Results Section -->
    <div id="calculation-results" class="mt-8 hidden w-full">
        <h2 class="text-2xl font-bold text-[#1167B1] mb-4 text-center hidden-animated">Hasil Perhitungan</h2>
        <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Angsuran Pokok/Bulan</p>
                    <p class="text-lg font-semibold text-[#1167B1]" id="monthly-principal"></p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Angsuran Bunga/Bulan</p>
                    <p class="text-lg font-semibold text-[#1167B1]" id="monthly-interest"></p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Total Angsuran/Bulan</p>
                    <p class="text-lg font-semibold text-[#1167B1]" id="total-monthly-payment"></p>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Jadwal Angsuran</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Angsuran Bunga</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Angsuran Pokok</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Angsuran</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sisa Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-table" class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loanDurationInput = document.getElementById('loan_duration');
        const interestRateInput = document.getElementById('interest_rate');
        const form = document.getElementById('loan-calculator-form');
        const resultsSection = document.getElementById('calculation-results');
        const monthlyPrincipal = document.getElementById('monthly-principal');
        const monthlyInterest = document.getElementById('monthly-interest');
        const totalMonthlyPayment = document.getElementById('total-monthly-payment');
        const scheduleTable = document.getElementById('schedule-table');
        const startMonthSelect = document.querySelector('select[name="start_month"]');
        const startYearSelect = document.querySelector('select[name="start_year"]');
        const endMonthSelect = document.querySelector('select[name="end_month"]');
        const endYearSelect = document.querySelector('select[name="end_year"]');

        // Update interest rate based on loan duration
        loanDurationInput.addEventListener('input', function () {
            const duration = parseInt(this.value);
            if (duration > 0) {
                interestRateInput.value = duration <= 6 ? '5%' : '10%';
            } else {
                interestRateInput.value = '';
            }
        });

        // Auto-update end date based on start date and duration
        function updateEndDate() {
            const duration = parseInt(loanDurationInput.value) || 0;
            const startMonth = parseInt(startMonthSelect.value) || 1;
            const startYear = parseInt(startYearSelect.value) || new Date().getFullYear();
            if (duration && startMonth && startYear) {
                const startDate = new Date(startYear, startMonth - 1);
                const endDate = new Date(startDate);
                endDate.setMonth(startDate.getMonth() + duration - 1);
                endMonthSelect.value = endDate.getMonth() + 1;
                endYearSelect.value = endDate.getFullYear();
            }
        }

        loanDurationInput.addEventListener('input', updateEndDate);
        startMonthSelect.addEventListener('change', updateEndDate);
        startYearSelect.addEventListener('change', updateEndDate);

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => { throw new Error(error.error || 'Terjadi kesalahan'); });
                }
                return response.json();
            })
            .then(data => {
                // Show results
                resultsSection.classList.remove('hidden');
                resultsSection.classList.add('show-animated');

                // Format currency
                const formatCurrency = (amount) => {
                    return 'Rp ' + amount.toLocaleString('id-ID');
                };

                // Update summary
                monthlyPrincipal.textContent = formatCurrency(data.monthly_principal);
                monthlyInterest.textContent = formatCurrency(data.monthly_interest);
                totalMonthlyPayment.textContent = formatCurrency(data.total_monthly_payment);

                // Update schedule table
                scheduleTable.innerHTML = '';
                data.schedule.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 py-2">${row.period}</td>
                        <td class="px-4 py-2">${formatCurrency(row.interest_payment)}</td>
                        <td class="px-4 py-2">${formatCurrency(row.principal_payment)}</td>
                        <td class="px-4 py-2">${formatCurrency(row.total_payment)}</td>
                        <td class="px-4 py-2">${formatCurrency(row.remaining_balance)}</td>
                    `;
                    scheduleTable.appendChild(tr);
                });

                // Scroll to results
                resultsSection.scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat menghitung. Silakan coba lagi.');
            });
        });
    });
</script>
```