<template>
  <div style="float:left;" class="countrys container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Manage Countries</h1>
    <div>
      <button @click="handleJsonButtonClick" v-show="!jsonButtonHidden">JSON</button>
      <button @click="handleXmlButtonClick" v-show="!xmlButtonHidden">XML</button>
    </div>
    <input class="form-control" placeholder="Enter Country" v-model="filterInput">
    <br />
    <table v-if="filteredCountries.length > 0" class="table table-striped">
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Continent</th>
          <th>Region</th>
          <th>Surface Area</th>
          <th>Indep Year</th>
          <th>Population</th>
          <th>Life Expectancy</th>
          <th>GNP</th>
          <th>GNP Old</th>
          <th>Local Name</th>
          <th>Government Form</th>
          <th>Head of State</th>
          <th>Capital</th>
          <th>Code2</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="country in filteredCountries" :key="country.Code">
          <td>{{ country.Code }}</td>
          <td>{{ country.Name }}</td>
          <td>{{ country.Continent }}</td>
          <td>{{ country.Region }}</td>
          <td>{{ country.SurfaceArea }}</td>
          <td>{{ country.IndepYear }}</td>
          <td>{{ country.Population }}</td>
          <td>{{ country.LifeExpectancy }}</td>
          <td>{{ country.GNP }}</td>
          <td>{{ country.GNPOld }}</td>
          <td>{{ country.LocalName }}</td>
          <td>{{ country.GovernmentForm }}</td>
          <td>{{ country.HeadOfState }}</td>
          <td>{{ country.Capital }}</td>
          <td>{{ country.Code2 }}</td>
          <td><router-link class="btn btn-default" :to="'/country/' + country.Code">View</router-link></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No data available.</p>
  </div>
</template>

<script>
import Alert from './Alert';

export default {
  name: 'countrys',
  data() {
    return {
      countries: [],
      filterInput: '',
      jsonButtonHidden: false,
      xmlButtonHidden: false,
    };
  },
  methods: {
    handleJsonButtonClick() {
      console.log('JSON button clicked');
      this.fetchData('application/json');
      this.jsonButtonHidden = true;
      this.xmlButtonHidden = true;
    },
    handleXmlButtonClick() {
      console.log('XML button clicked');
      this.fetchData('application/xml');
      this.jsonButtonHidden = true;
      this.xmlButtonHidden = true;
    },
    fetchData(acceptHeader) {
      const url = 'http://localhost/dataprocessing/public/api/country';
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
            this.countries = data;
          } else if (acceptHeader === 'application/xml') {
            console.log('Received XML data:', data);
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'text/xml');
            const countryNodes = xmlDoc.querySelectorAll('country');
            const countries = Array.from(countryNodes).map(countryNode => {
              return {
                Code: countryNode.querySelector('Code').textContent,
                Name: countryNode.querySelector('Name').textContent,
                Continent: countryNode.querySelector('Continent').textContent,
                Region: countryNode.querySelector('Region').textContent,
                SurfaceArea: countryNode.querySelector('SurfaceArea').textContent,
                IndepYear: countryNode.querySelector('IndepYear').textContent,
                Population: countryNode.querySelector('Population').textContent,
                LifeExpectancy: countryNode.querySelector('LifeExpectancy').textContent,
                GNP: countryNode.querySelector('GNP').textContent,
                GNPOld: countryNode.querySelector('GNPOld').textContent,
                LocalName: countryNode.querySelector('LocalName').textContent,
                GovernmentForm: countryNode.querySelector('GovernmentForm').textContent,
                HeadOfState: countryNode.querySelector('HeadOfState').textContent,
                Capital: countryNode.querySelector('Capital').textContent,
                Code2: countryNode.querySelector('Code2').textContent,
              };
            });
            this.countries = countries;
          }
        })
        .catch(error => {
          console.error('Error occurred:', error);
        });
    },
    filterBy(list, value) {
      value = value.charAt(0).toUpperCase() + value.slice(1);
      return list.filter(country => {
        return country.Name.indexOf(value) > -1;
      });
    },
  },
  created() {
    if (this.$route.query.alert) {
      this.alert = this.$route.query.alert;
    }
    this.fetchCountries();
  },
  components: {
    Alert,
  },
  computed: {
    filteredCountries() {
      return this.filterBy(this.countries, this.filterInput);
    },
  },
};
</script>

<style scoped>
/* CSS styles */
</style>
