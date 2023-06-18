<template>
    <div>
      <h1>City Population</h1>
      <div>
        <button @click="handleJsonButtonClick" v-show="!jsonButtonHidden">JSON</button>
        <button @click="handleXmlButtonClick" v-show="!xmlButtonHidden">XML</button>
      </div>
      <svg ref="chart" v-if="showChart"></svg>
    </div>
  </template>
  
  <script>
  import * as d3 from 'd3';
  
  export default {
    name: 'city-population',
    data() {
      return {
        cities: [],
        jsonButtonHidden: false,
        xmlButtonHidden: false,
        showChart: false,
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
  const url = 'http://localhost/dataprocessing/public/api/city';

  fetch(url, {
    headers: {
      Accept: acceptHeader,
    },
  })
    .then((response) => {
      if (acceptHeader === 'application/json') {
        return response.json();
      } else if (acceptHeader === 'application/xml') {
        return response.text();
      } else {
        throw new Error('Invalid accept header');
      }
    })
    .then((data) => {
      if (acceptHeader === 'application/json') {
        console.log('Received JSON data:', data);
        this.cities = data
          .filter((city) => city.CountryCode === 'NLD')
          .map((city) => ({
            Name: city.Name,
            CountryCode: city.CountryCode,
            Population: +city.Population, // Convert to numeric value
          }));
        this.dataFormat = 'json';
      } else if (acceptHeader === 'application/xml') {
        console.log('Received XML data:', data);
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(data, 'text/xml');
        const cities = Array.from(xmlDoc.getElementsByTagName('city')).map((city) => {
          const name = city.querySelector('Name').textContent;
          const countryCode = city.querySelector('CountryCode').textContent;
          const population = parseInt(city.querySelector('Population').textContent);
          return { Name: name, CountryCode: countryCode, Population: population };
        });
        this.cities = cities.filter((city) => city.CountryCode === 'NLD');
      }

      this.showChart = true;
      this.$nextTick(() => {
        this.drawChart();
      });
    })
    .catch((error) => {
      console.error('Error occurred:', error);
    });
}
,
      drawChart() {
        const margin = { top: 20, right: 20, bottom: 200, left: 100 };
        const width = 1600 - margin.left - margin.right;
        const height = 800 - margin.top - margin.bottom;
  
        const svg = d3.select(this.$refs.chart)
          .attr('width', width + margin.left + margin.right)
          .attr('height', height + margin.top + margin.bottom)
          .append('g')
          .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');
  
        const x = d3.scaleBand()
          .range([0, width])
          .padding(0.1);
  
        const y = d3.scaleLinear()
          .range([height, 0]);
  
        x.domain(this.cities.map((d) => d.Name));
  
        const maxPopulation = d3.max(this.cities, (d) => d.Population);
        const maxRange = Math.max(maxPopulation) * 1.1;
        const scalingFactor = height / maxRange;
        y.domain([0, maxRange]);
  
        svg.selectAll('.bar')
          .data(this.cities)
          .enter()
          .append('rect')
          .attr('class', 'bar')
          .attr('x', (d) => x(d.Name))
          .attr('width', x.bandwidth())
          .attr('y', (d) => y(d.Population))
          .attr('height', (d) => height - y(d.Population))
          .attr('fill', 'steelblue');
  
        svg.append('g')
          .attr('transform', 'translate(0,' + height + ')')
          .call(d3.axisBottom(x))
          .selectAll('text')
          .attr('transform', 'rotate(-45)')
          .attr('dx', '-.8em')
          .attr('dy', '.15em')
          .style('text-anchor', 'end')
          .style('font-size', '12px');
  
        svg.append('g')
          .call(d3.axisLeft(y));
      },
    },
  };
  </script>
  
  <style scoped>
  .bar {
    fill: steelblue;
  }
  </style>
  