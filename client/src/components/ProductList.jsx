import axios from 'axios'
import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'

import ProductItem from './ProductItem'
import './ProductList.scss'

export default function ProductList() {
  const [products, setProducts] = useState([])
  const [checkedProducts, setCheckedProducts] = useState([])

  useEffect(() => {
    getProducts()
  }, [])

  const getProducts = () => {
    axios.get('http://localhost:80/').then(response => {
      setProducts(response.data)
    })
  }

  const massDeleteProduct = () => {
    console.log(checkedProducts)
    axios
      .delete('http://localhost:80', { data: { skuList: checkedProducts } })
      .then(() => {
        getProducts()
        // setProducts(
        //   products.filter(value => !checkedProducts.includes(value.sku))
        // )
        setCheckedProducts([])
      })
  }

  const handleProductChange = sku => {
    if (checkedProducts.includes(sku)) {
      const newChecked = checkedProducts.filter(value => value !== sku)
      setCheckedProducts(newChecked)
      return
    }

    setCheckedProducts([...checkedProducts, sku])
  }

  return (
    <div className='product-list container'>
      {/* Header */}
      <header className='product-list__header'>
        <h2 className='product-list__title'>Product List</h2>

        <Link to='add-product' className='btn btn--add'>
          ADD
        </Link>

        <button className='btn btn--delete' onClick={massDeleteProduct}>
          MASS DELETE
        </button>
      </header>

      {/* Product list */}
      <div className='product-list__content'>
        {products.map(product => (
          <ProductItem
            key={product.sku}
            data={product}
            handleProductChange={handleProductChange}
          />
        ))}
      </div>
    </div>
  )
}
