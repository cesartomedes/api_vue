<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>APIREst with PHP-VUE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
    <div id="app">
        <div class="container">

            <div class="card">
                <div class="card-header">Alumnos</div>
                <div class="card-body">
                    <form @submit.prevent="crearAlumno">
                        Nombre:
                        <input type="text" class="form-" name="nombres" v-model="nuevoAlumno.nombres" id="nombres">
                        Apellido:
                        <input type="text" name="apellidos" v-model="nuevoAlumno.apellidos" id="apellidos">
                        <button type="submit">Agregar Alumno</button>

                    </form>
                </div>
                <div class="card-footer text-muted"></div>
            </div>

            <ul>
                <li v-for="alumno in alumnos" :key="alumno.id">
                    {{ alumno.nombres }} - {{ alumno.apellidos }}
                    <button @click="eliminarAlumno(alumno.id)">Eliminar</button>
                </li>
            </ul>

        </div>


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

                const eliminarAlumno = async (id) => {
                    await axios.delete(`${apiUrl}/${id}`);
                    obtenerAlumnos();
                };

                const crearAlumno = async () => {
                    try {
                        const respuesta = await axios.post(apiUrl, nuevoAlumno.value);
                        alumnos.value.push(respuesta.data);
                        nuevoAlumno.value = {
                            nombres: "",
                            apellidos: ""
                        };
                        obtenerAlumnos();
                    } catch (error) {
                        console.log("Error al crear el alumno", error)
                    }
                }
                onMounted(() => {
                    obtenerAlumnos();
                });
                return {
                    alumnos,
                    crearAlumno,
                    nuevoAlumno,
                    eliminarAlumno
                };
            }
        });

        app.mount('#app');
    </script>
</body>

</html>