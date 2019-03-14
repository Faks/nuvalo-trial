<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Company</th>
                <th>Employee</th>
                <th>Begin</th>
                <th>End</th>
                <th>Total Hours</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="work_hour in work_hours.data">
                <td>{{ work_hour.employee.company.name }}</td>
                <td>{{ work_hour.employee.fname }} {{ work_hour.employee.lname }}</td>
                <td>{{ work_hour.start }}</td>
                <td>{{ work_hour.end }}</td>
                <td>{{ work_hour.total_hours }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                work_hours: [],
                errors: [],
            }
        },
        // Fetches posts when the component is created.
        mounted() {
            axios.get('/json-filter3')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.work_hours = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        }
    }
</script>
