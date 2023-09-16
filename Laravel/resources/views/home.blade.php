<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="flex justify-center flex-col">
    <div class="flex justify-center">
        <div class="p-3 m-2 bg-orange-700">
            <a class=" text-white cursor-pointer" href="/customer">Add Customer</a>
        </div>

        <div class="p-3 m-2 bg-orange-700">
            <a class=" text-white cursor-pointer" href="/nationality">Add Nationality</a>
        </div>

    </div>
    <div class="flex justify-center py-2">
        <div class="flex justify-center flex-col  w-1/2">
            <div>
                Customer List
            </div>
            <div id="customer_list" class="flex justify-center flex-col">

            </div>
        </div>
    </div>


</body>

<script src="{{asset('js/app.js')}}"></script>
<script>
    const fetchCustomer = () => {
        const customerList = document.getElementById("customer_list");

        window?.axios?.get("/api/customer").then((res) => {
            let data = res?.data?.data || [];
            if (data.length === 0) {
                customerList.innerHTML = "No data";
                return;
            }
            let html = "";

            // create simple table
            html += "<table class='table-auto'>";
            html += "<thead>";
            html += "<tr>";
            html += "<th class='px-4 py-2'>Name</th>";
            html += "<th class='px-4 py-2'>Date of Birth</th>";
            html += "<th class='px-4 py-2'>Phone Number</th>";
            html += "<th class='px-4 py-2'>Email</th>";
            html += "<th class='px-4 py-2'>Action</th>";
            html += "</tr>";
            html += "</thead>";
            html += "<tbody>";

            data.forEach((item) => {
                html += "<tr>";
                html += "<td class='border px-4 py-2'>" + item.cst_name + "</td>";
                html += "<td class='border px-4 py-2'>" + item.cst_dob + "</td>";
                html += "<td class='border px-4 py-2'>" + item.cst_phoneNum + "</td>";
                html += "<td class='border px-4 py-2'>" + item.cst_email + "</td>";
                html += "<td class='border px-4 py-2'>";
                html += "<a class='text-blue-500 cursor-pointer' href='/customer/" + item.cst_id + "?isEdit=true'>Edit</a> | ";
                html += "<button class='text-red-500 cursor-pointer' onclick='handleCustomerDelete(" + item.cst_id + ")'>Delete</button>";
                html += "</td>";
                html += "</tr>";
            });

            html += "</tbody>";
            html += "</table>";



            customerList.innerHTML = html;
        }).catch((err) => {
            alert(err?.response?.data?.message || err?.message || "Terjadi kesalahan");
        });
    }

    const handleCustomerDelete = (id) => {
        // DELETE /api/customer/{id}

        // show confirmation
        if (!confirm("Are you sure?")) {
            return;
        }

        window?.axios?.delete("/api/customer/" + id).then((res) => {
            alert(res?.data?.message || "Success");
            fetchCustomer();
        }).catch((err) => {
            alert(err?.message || err?.response?.data?.message || "Terjadi kesalahan");
        });
    }

    window.onload = () => {
        fetchCustomer();
    }
</script>

</html>