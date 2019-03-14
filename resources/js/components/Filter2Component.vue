<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Month / Year</th>
                <th>Hours Worked</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="each_month in each_month_total_hours">
                <td>{{ each_month.month }}</td>
                <td>{{ each_month.hours }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                each_month_total_hours: [],
                errors: [],
            }
        },
        // Fetches posts when the component is created.
        mounted() {
            axios.get('/json-filter2')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.each_month_total_hours = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        }
    }
</script>