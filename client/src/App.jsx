import './App.scss'
import React from 'react'
import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Main from './components/Main'
import ProductList from './components/ProductList'
import Footer from './components/Footer'
import ProductCreate from './components/ProductCreate'

function App() {
  return (
    <div className='App'>
      <Main>
        <BrowserRouter>
          <Routes>
            <Route index element={<ProductList />} />
            <Route path='add-product' element={<ProductCreate />} />
            <Route path='*' element={<Footer />}>
              sdf
            </Route>
          </Routes>
        </BrowserRouter>
      </Main>

      <Footer />
    </div>
  )
}

export default App
