<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nationality</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="flex justify-center flex-col">
    <div class="flex justify-center">
        <div class="p-3 m-2 bg-orange-700">
            <a class=" text-white cursor-pointer" href="/">Back</a>
        </div>
        <div class="p-3 m-2 ">
            Manage Nationality
        </div>

        <!-- <div class="p-3 m-2 bg-orange-700">
            <a class=" text-white cursor-pointer">Add Nationality</a>
        </div> -->

    </div>
    <div class="flex justify-center py-2">
        <div class="flex justify-center flex-col  w-1/2">
            <form id="nationality_form">
                <div id="title">
                    Tambahkan Negara Baru
                </div>
                <div class="flex flex-col py-2">
                    <input type="hidden" name="nationality_id" id="nationality_id">
                    <label for="nationality_code" class="font-medium text-xl">Kode Negara</label>
                    <input type="text" name="nationality_code" id="nationality_code" placeholder="Masukkan Kode Negara" class="border-2 py-2 px-1">
                </div>
                <div class="flex flex-col py-2">
                    <label for="nationality_name" class="font-medium text-xl">Nama Negara</label>
                    <input type="text" name="nationality_name" id="nationality_name" placeholder="Masukkan Nama Negara" class="border-2 py-2 px-1">
                </div>
                <div class="flex flex-col py-2">
                    <button class="text-white bg-orange-700  h-[44px] mt-[26px]" type="submit">Submit</button>
                </div>
            </form>
            <div>
                Nationality List
            </div>
            <div id="nationality_list" class="flex justify-center flex-col">

            </div>
        </div>
    </div>


</body>

<script src="{{asset('js/app.js')}}"></script>
<script>
    const fetchNationality = () => {
        const nationalityList = document.getElementById("nationality_list")
        window?.axios?.get("/api/nationality").then((res) => {
            let data = res?.data?.data ?? [];
            if (data.length === 0) {
                nationalityList.innerHTML = "No data";
                return;
            }
            let html = "";

            // {
            //     "national_id": 1,
            //     "national_name": "Indonesia",
            //     "national_code": "ID"
            // },

            // create simple table
            html += "<table class='table-auto'>";
            html += "<thead>";
            html += "<tr>";
            html += "<th class='px-4 py-2'>ID</th>";
            html += "<th class='px-4 py-2'>Kode Negara</th>";
            html += "<th class='px-4 py-2'>Nama Negara</th>";
            html += "<th class='px-4 py-2'>Action</th>";
            html += "</tr>";
            html += "</thead>";
            html += "<tbody>";

            data.forEach((item) => {
                html += "<tr id='" + item.national_id + "'>";
                html += "<td class='border px-4 py-2'>" + item.national_id + "</td>";
                html += "<td class='border px-4 py-2'>" + item.national_code + "</td>";
                html += "<td class='border px-4 py-2'>" + item.national_name + "</td>";
                html += "<td class='border px-4 py-2'>";
                html += `<button class='text-blue-500 cursor-pointer' onclick='handleNationalityEdit(${item.national_id})'>Edit</button> | `;
                html += "<button class='text-red-500 cursor-pointer' onclick='handleNationalityDelete(" + item.national_id + ")'>Delete</button>";
                html += "</td>";
                html += "</tr>";
            });

            html += "</tbody>";
            html += "</table>";

            nationalityList.innerHTML = html;
        }).catch((err) => {
            console.log(err);
        })
    }

    const handleNationalityDelete = (id) => {
        // DELETE /api/nationality/{id}

        // show confirmation
        if (!confirm("Are you sure?")) {
            return;
        }

        window?.axios?.delete("/api/nationality/" + id).then((res) => {
            alert(res?.data?.message ?? "Success");
            fetchNationality();
        }).catch((err) => {
            alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
        });
    }

    const title = document.getElementById("title");

    const handleNationalityEdit = (id) => {
        // get element input 
        const nationalId = document.getElementById("nationality_id");
        const nationalCode = document.getElementById("nationality_code");
        const nationalName = document.getElementById("nationality_name");

        // get data from row table
        const row = document.getElementById(id);
        console.log(row);
        const item = {
            national_id: row.children[0].innerHTML,
            national_code: row.children[1].innerHTML,
            national_name: row.children[2].innerHTML,
        }
        console.log(item);

        title.innerHTML = "Edit Negara " + item.national_id;

        nationalId.value = item.national_id;
        nationalCode.value = item.national_code;
        nationalName.value = item.national_name;
    }

    const handleFormSubmit = (e) => {
        e.preventDefault();
        const nationalId = document.getElementById("nationality_id");
        const isEdit = nationalId && nationalId.value !== "";

        const nationalCode = document.getElementById("nationality_code");
        const nationalName = document.getElementById("nationality_name");

        if (nationalCode.value === "" || nationalName.value === "") {
            alert("Mohon isi semua field");
            return;
        }

        const data = {
            national_code: nationalCode.value,
            national_name: nationalName.value,
        }


        if (isEdit) {
            data.national_id = nationalId.value;

            window?.axios?.put(`/api/nationality/${data.national_id}`, data, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                alert(res?.data?.message || "Berhasil mengubah negara");
                // reset form
                nationalId.value = "";
                nationalCode.value = "";
                nationalName.value = "";
                title.innerHTML = "Tambahkan Negara Baru";
                fetchNationality();
            }).catch(err => {
                console.log(err?.response);
                alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
            })
            return;
        }


        window?.axios?.post(`/api/nationality`, data, {
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => {
            alert(res?.data?.message || "Berhasil menambahkan negara");
            nationalId.value = "";
            nationalCode.value = "";
            nationalName.value = "";
            title.innerHTML = "Tambahkan Negara Baru";
            fetchNationality();

        }).catch(err => {
            console.log(err?.response);
            alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
        })

    }

    const nationalityForm = document.getElementById("nationality_form")
    nationalityForm.addEventListener("submit", handleFormSubmit);

    window.onload = () => {
        fetchNationality();
    }
</script>

</html>