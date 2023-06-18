<template>
  <div style="float: left;" class="citys container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Manage Cities</h1>
    <div>
      <button @click="handleJsonButtonClick" v-show="!jsonButtonHidden">JSON</button>
      <button @click="handleXmlButtonClick" v-show="!xmlButtonHidden">XML</button>
    </div>
    <br />
    <input class="form-control" placeholder="Enter City" v-model="filterInput">
    <br />
    <table v-if="filteredCities.length > 0" class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>CountryCode</th>
          <th>District</th>
          <th>Population</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="city in filteredCities" :key="city.ID">
          <td>{{ city.ID }}</td>
          <td>{{ city.Name }}</td>
          <td>{{ city.CountryCode }}</td>
          <td>{{ city.District }}</td>
          <td>{{ city.Population }}</td>
          <td><router-link class="btn btn-default" v-bind:to="'/city/'+city.ID">View</router-link></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No data available.</p>
  </div>
</template>

<script>
import Alert from './Alert';

export default {
  name: 'Citys',
  data() {
    return {
      cities: [],
      filterInput: '',
      jsonButtonHidden: false,
      xmlButtonHidden: false,
    };
  },
  methods: {
    handleJsonButtonClick() {
      console.log('JSON button clicked');
      this.xmlButtonHidden = true; // Hide XML button
      this.fetchData('application/json');
      this.jsonButtonHidden = true;
    },
    handleXmlButtonClick() {
      console.log('XML button clicked');
      this.jsonButtonHidden = true; // Hide JSON button
      this.fetchData('application/xml');
      this.xmlButtonHidden = true;
    },
    fetchData(acceptHeader) {
      const url = 'http://localhost/dataprocessing/public/api/city';
      fetch(url, {
        headers: {
          Accept: acceptHeader,
        },
      })
        .then(response => {
          if (acceptHeader === 'application/json') {
            return response.json();
          } else if (acceptHeader === 'application/xml') {
            return response.text();
          } else {
            throw new Error('Invalid accept header');
          }
        })
        .then(data => {
          if (acceptHeader === 'application/json') {
            console.log('Received JSON data:', data);
            this.cities = data;
          } else if (acceptHeader === 'application/xml') {
            console.log('Received XML data:', data);
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'text/xml');
            const cityNodes = xmlDoc.querySelectorAll('city');
            const cities = Array.from(cityNodes).map(cityNode => {
              return {
                ID: cityNode.querySelector('ID').textContent,
                Name: cityNode.querySelector('Name').textContent,
                CountryCode: cityNode.querySelector('CountryCode').textContent,
                District: cityNode.querySelector('District').textContent,
                Population: cityNode.querySelector('Population').textContent,
              };
            });
            this.cities = cities;
          }
        })
        .catch(error => {
          console.error('Error occurred:', error);
        });
    },
    filterBy(list, value) {
      value = value.charAt(0).toUpperCase() + value.slice(1);
      return list.filter(city => {
        return city.Name.indexOf(value) > -1;
      });
    },
  },
  created() {
    if (this.$route.query.alert) {
      this.alert = this.$route.query.alert;
    }
    this.fetchCities();
  },
  components: {
    Alert,
  },
  computed: {
    filteredCities() {
      return this.filterBy(this.cities, this.filterInput);
    },
  },
};
</script>

<style scoped>
/* Add custom styles here */
</style>
