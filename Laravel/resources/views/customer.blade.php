<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="flex justify-center w-full">
    <div class="flex justify-center flex-col w-1/2">
        <div id="title" class="py-3 my-2 text-3xl font-semibold">
            User
        </div>
        <form id="customer_form">
            <div class="flex flex-col py-2">
                <label for="cst_name" class="font-medium text-xl">Nama</label>
                <input type="text" name="cst_name" id="cst_name" placeholder="Masukkan nama anda" class="border-2 py-2 px-1">
            </div>
            <div class="flex flex-col py-2">
                <label for="cst_dob" class="font-medium text-xl">Tanggal Lahir</label>
                <input type="date" name="cst_dob" id="cst_dob" placeholder="Masukkan tanggal lahir anda" class="border-2 py-2 px-1">
            </div>

            <div class="flex flex-col py-2">
                <label for="cst_phoneNum" class="font-medium text-xl">Nomor Telepon</label>
                <input type="text" name="cst_phoneNum" id="cst_phoneNum" placeholder="Masukkan nomor telepon anda" class="border-2 py-2 px-1">
            </div>

            <div class="flex flex-col py-2">
                <label for="cst_email" class="font-medium text-xl">Email</label>
                <input type="email" name="cst_email" id="cst_email" placeholder="Masukkan email anda" class="border-2 py-2 px-1">
            </div>
            <div class="flex flex-col py-2">
                <label for="national_id" class="font-medium text-xl">Kewarganegaraan</label>
                <select name="national_id" id="national_id" class="border-2 py-2 px-1">
                    <option value="" selected disabled>Pilih kewarganegaraan anda</option>
                </select>
            </div>
            <div class="flex flex-col py-2">
                <div class="flex flex-row justify-between">
                    <p class="font-medium text-xl">Keluarga</p>
                    <button class="text-blue-400 hover:text-blue-600" type="button" onclick="handleTambahkanKeluarga()">+ Tambahkan Keluarga</button>
                </div>
                <div class="flex flex-col" id="family_list">
                    <div class="flex flex-row">
                        <div class="flex flex-col py-2 px-1 w-1/3">
                            <label for="fl_name" class="font-medium text-xl">Nama</label>
                            <input type="text" name="fl_name" id="fl_name" placeholder="Nama keluarga anda" class="border-2 py-2 px-1">
                        </div>
                        <div class="flex flex-col py-2 px-1 w-1/3">
                            <label for="fl_relation" class="font-medium text-xl">Hubungan</label>
                            <input type="text" name="fl_relation" id="fl_relation" placeholder="Masukkan hubungan anda" class="border-2 py-2 px-1">
                        </div>

                        <div class="flex flex-col py-2 px-1 w-1/3">
                            <label for="fl_dob" class="font-medium text-xl">Tanggal Lahir</label>
                            <input type="date" name="fl_dob" id="fl_dob" placeholder="Masukkan tanggal lahir anda" class="border-2 py-2 px-1 h-[44px]">
                        </div>
                        <div class="flex flex-col py-2 px-1 w-1/6 justify-center text-center">
                            <button class="text-white bg-orange-700  h-[44px] mt-[26px]" type="button" onclick="handleHapusKeluarga(this)">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col py-2">
                <button class="text-white bg-orange-700  h-[44px] mt-[26px]" type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
<script src="{{asset('js/app.js')}}"></script>
<script>
    let isEdit = false

    // check isEdit from url search query param
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('isEdit')) {
        isEdit = urlParams.get('isEdit') === 'true';
    }

    // check if url path has id
    const url = window.location.href;
    const id = url.split('/').pop();
    console.log(id);
    if (id && id !== 'customer') {
        isEdit = true;
    }


    const title = document.getElementById('title');
    if (isEdit) {
        title.innerHTML = "Edit User";
    } else {
        title.innerHTML = "User";
    }

    const handleTambahkanKeluarga = () => {
        const family_list = document.getElementById('family_list');
        const keluarga = document.createElement('div');
        keluarga.classList.add('flex', 'flex-row');
        keluarga.innerHTML = `
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_name" class="font-medium text-xl">Nama</label>
                    <input type="text" name="fl_name" id="fl_name" placeholder="Nama keluarga anda" class="border-2 py-2 px-1">
                </div>
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_relation" class="font-medium text-xl">Hubungan</label>
                    <input type="text" name="fl_relation" id="fl_relation" placeholder="Masukkan hubungan anda" class="border-2 py-2 px-1">
                </div>
                
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_dob" class="font-medium text-xl">Tanggal Lahir</label>
                    <input type="date" name="fl_dob" id="fl_dob" placeholder="Masukkan tanggal lahir anda" class="border-2 py-2 px-1 h-[44px]">
                </div>
                <div class="flex flex-col py-2 px-1 w-1/6 justify-center text-center">
                    <button class="text-white bg-orange-700  h-[44px] mt-[26px]" type="button" onclick="handleHapusKeluarga(this)">Hapus</button>
                </div>
            
        `;
        family_list.appendChild(keluarga);
    }

    const handleHapusKeluarga = (element) => {
        const keluarga = element.parentElement.parentElement;
        keluarga.remove();
    }

    const fetchNationality = () => {
        //  GET /api/nationality
        window?.axios?.get("/api/nationality").then(res => {
            data = res?.data?.data || [];

            const national_id = document.getElementById('national_id');
            national_id.innerHTML = `
                <option value="" selected disabled>Pilih kewarganegaraan anda</option>
                ${data.map((item) => `<option value="${item.national_id}">${item.national_name}</option>`).join('')}
            `;
        }).catch(err => {
            alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
        })
    }

    const handleFormSubmit = (e) => {
        e.preventDefault();
        console.log("submitting");
        const cst_name = document.getElementById('cst_name').value;
        const cst_dob = document.getElementById('cst_dob').value;
        const cst_phoneNum = document.getElementById('cst_phoneNum').value;
        const cst_email = document.getElementById('cst_email').value;
        const national_id = document.getElementById('national_id').value;
        const family_list = document.getElementById('family_list').children;

        // valdate first, all required except family_list
        if (!cst_name || !cst_dob || !cst_phoneNum || !cst_email || !national_id) {
            alert("Mohon isi semua field");
            return;
        }

        const data = {
            cst_name,
            cst_dob,
            cst_phoneNum,
            cst_email,
            national_id,
            family_list: []
        };

        for (let i = 0; i < family_list.length; i++) {
            const fl_name = family_list[i].querySelector('#fl_name').value;
            const fl_relation = family_list[i].querySelector('#fl_relation').value;
            const fl_dob = family_list[i].querySelector('#fl_dob').value;

            // check if dummy form empty, if empty, skip
            if (!fl_name && !fl_relation && !fl_dob) {

                continue;
            }

            // valdate first, all required
            if (!fl_name || !fl_relation || !fl_dob) {
                alert("Mohon isi semua field di keluarga");
                return;
            }

            data.family_list.push({
                fl_name,
                fl_relation,
                fl_dob
            });
        }

        if (!isEdit) {
            // POST /api/customer
            window?.axios?.post("/api/customer", data).then(res => {
                alert(res?.data?.message || "Berhasil menambahkan customer");
                window.location = "/";
            }).catch(err => {
                alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
            })
        } else {
            // get id from url path
            const url = window.location.href;
            const id = url.split('/').pop();

            data.national_id = parseInt(data.national_id);

            // PUT /api/customer/{id}
            window?.axios?.put(`/api/customer/${id}`, data, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                alert(res?.data?.message || "Berhasil mengubah customer");
                window.location = "/";
            }).catch(err => handleFormError(err))
        }

    }

    const customer_form = document.getElementById('customer_form');
    customer_form.addEventListener('submit', handleFormSubmit);

    const fetchCustomerByID = () => {
        // get id from url path
        const url = window.location.href;
        const id = url.split('/').pop();

        // GET /api/customer/{id}
        window?.axios?.get(`/api/customer/${id}`).then(res => {
            const data = res?.data?.data || {};
            const cst_name = document.getElementById('cst_name');
            const cst_dob = document.getElementById('cst_dob');
            const cst_phoneNum = document.getElementById('cst_phoneNum');
            const cst_email = document.getElementById('cst_email');
            const national_id = document.getElementById('national_id');
            const family_list = document.getElementById('family_list');

            if (data.family_list?.length !== 0) {
                // remove first child from family_list
                family_list.removeChild(family_list.firstElementChild);
            }


            cst_name.value = data.cst_name;
            cst_dob.value = data.cst_dob;
            cst_phoneNum.value = data.cst_phoneNum;
            cst_email.value = data.cst_email;
            national_id.value = data.national_id;

            data.family_list.forEach((item) => {
                const keluarga = document.createElement('div');
                keluarga.classList.add('flex', 'flex-row');
                keluarga.innerHTML = `
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_name" class="font-medium text-xl">Nama</label>
                    <input type="text" name="fl_name" id="fl_name" placeholder="Nama keluarga anda" class="border-2 py-2 px-1" value="${item.fl_name}">
                </div>
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_relation" class="font-medium text-xl">Hubungan</label>
                    <input type="text" name="fl_relation" id="fl_relation" placeholder="Masukkan hubungan anda" class="border-2 py-2 px-1" value="${item.fl_relation}">
                </div>
                
                <div class="flex flex-col py-2 px-1 w-1/3">
                    <label for="fl_dob" class="font-medium text-xl">Tanggal Lahir</label>
                    <input type="date" name="fl_dob" id="fl_dob" placeholder="Masukkan tanggal lahir anda" class="border-2 py-2 px-1 h-[44px]" value="${item.fl_dob}">
                </div>
                <div class="flex flex-col py-2 px-1 w-1/6 justify-center text-center">
                    <button class="text-white bg-orange-700  h-[44px] mt-[26px]" type="button" onclick="handleHapusKeluarga(this)">Hapus</button>
                </div>

            `;
                family_list.appendChild(keluarga);
            });
        }).catch(err => {
            alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
            if (err?.response?.status === 404) {
                window.location = "/";
            }
        })
    }

    const handleFormError = (err) => {
        if (err?.response?.status === 400) {
            let errors = err?.response?.data?.errors || {};
            let message = "";

            for (const key in errors) {
                if (Object.hasOwnProperty.call(errors, key)) {
                    const element = errors[key];
                    message += element[0] + "\n";
                }
            }


            alert(message);
            return;
        }
        alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
    }

    window.onload = () => {
        fetchNationality();
        if (isEdit) {
            fetchCustomerByID();
        }
    }
</script>

</html>