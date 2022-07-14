<template>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-sm-4">            
            <div class="card">
                <div class="card-header">Pesquisar por nome repositório</div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">                                    
                                    <label for="repo">Nome repositório</label>
                                    <input type="text" class="form-control" id="repo" aria-describedby="repo" placeholder="Informe o repositóro" required v-model='repo'>
                                    <small id="repo" class="form-text text-muted">Informe o repositório</small>
                                    <p style="color:blue;"> {{dado['nome']}}</p>                                    
                                </div>
                            </div>                         
                        </div>                               
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-sm" @click="getRepo()">Pesquisar</button>            
                </div>
            </div>            
        </div>
        <div class="col-sm-4">            
            <div class="card">
                <div class="card-header">Pesquisar os ultimos commits</div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">                                    
                                    <label for="user">User GitHUB</label>
                                    <input type="text" class="form-control" id="user" aria-describedby="cep" placeholder="Informe o user" required v-model='user'>
                                    <small id="cep" class="form-text text-muted">Informe o usuario do GitHub</small>
                                    <label for="repositorio">Repositório</label>
                                    <input type="text" class="form-control" id="repositorio" aria-describedby="repositorio" placeholder="Informe o repositório" required v-model='repositorio'>
                                    <small id="repositorio" class="form-text text-muted">Informe o nome do repositório</small>
                                </div>
                            </div>                         
                        </div>                               
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-sm" @click="getLista()">Pesquisar</button>            
                </div>
            </div>            
        </div>
            <div class="col-sm-4">                
                
                        <div class="card">                 
                            <div class="card-header">Lista usuarios e datas ultimos commits</div>
                                <div class="card-body">            
                                <tr  v-for="m in lista" :key="id">
                                <td>{{m.commit['author']['name']}} - {{m.commit['author']['date'] | moment}}</td>
                                </tr>         
                            </div>                         
                        </div>
            </div>                                            
        </div>
    </div>
</div>
</template>
<script>
    export default {       
        data() {
      return {
        urlBase: 'http://127.0.0.1:8000/api/',     
        repositorio: '',
        user: '',
        lista: [],
        oldestFirst: false,
        repo: '',
        dado: ''       
      }
    },  filters: {
                moment: function (date) {
                    return moment(date).format('DD/MM/YYYY');
                }
                },
        methods: {
                toggleSort: function() {
                this.oldestFirst = !this.oldestFirst;
                },            
                getLista(){
                    axios.get(this.urlBase+'buscar/'+this.user+'/'+this.repositorio)
                        .then(response =>{            
                        this.lista = response.data
                        toggleSort()
                        console.log(response)
                    })
                        .catch(errors => {
                            console.log(errors);
                    })
                },
                getRepo(){
                    axios.get(this.urlBase+'search/'+this.repo)
                        .then(response =>{            
                        this.dado = response.data            
                        console.log(response)
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
                }
      
        },
        computed: {
                newDates: function() {
                    var order = this.oldestFirst ? 1 : -1;      
                    this.lista.sort(function(a, b) {
                    a = new Date(a.date);
                    b = new Date(b.date);
                    var results = a > b ? -1 : a < b ? 1 : 0;
                    return results * order;
                    });
                }    
        }
  }
</script>
