<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>APIREst with PHP-VUE</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>

    <div id="app">
        <form @submit.prevent="crearAlumno">
            Nombre:
            <input type="text" name="nombres" v-model="nuevoAlumno.nombres" id="nombres">
            Apellido:
            <input type="text" name="apellidos" v-model="nuevoAlumno.apellidos" id="apellidos">
            <button type="submit">Agregar Alumno</button>

        </form>
        <h1>Alumnos</h1>
        <ul>
            <li v-for="alumno in alumnos" :key="alumno.id">
                {{ alumno.nombres }} - {{ alumno.apellidos }}
            </li>
        </ul>

    </div>
    <script>
        const {
            createApp,
            ref,
            onMounted
        } = Vue;
        const apiUrl = 'http://localhost:8080';
        const app = createApp({
            setup() {
                const alumnos = ref([]);

                const nuevoAlumno = ref({
                    nombres: '',
                    apellidos: ''
                });

                const obtenerAlumnos = async () => {
                    const respuesta = await axios.get(apiUrl);
                    alumnos.value = respuesta.data;
                };
                const crearAlumno = async () => {
                    try {
                        const respuesta = await axios.post(apiUrl, nuevoAlumno.value);
                        alumnos.value.push(respuesta.data);
                        nuevoAlumno.value={ nombres: "", apellidos:""};
                      
                    } catch (error) {
                        console.log("Error al crear el alumno", error)
                    }
                }
                onMounted(() => {
                    obtenerAlumnos();
                });
                return {
                    alumnos, crearAlumno, nuevoAlumno
                };
            }
        });

        app.mount('#app');
    </script>
</body>

</html>