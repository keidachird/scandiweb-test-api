import { useState } from 'react'
import './ProductItem.scss'

export default function ProductItem({ data, handleProductChange }) {
  const [isChecked, setIsChecked] = useState(false)

  const getProductInfo = data => {
    switch (data.type) {
      case 'dvd':
        return `Size: ${data.size} MB`
      case 'book':
        return `Weight: ${data.weight} KG`
      case 'furniture':
        return `Dimension: ${data.height}x${data.width}x${data['length']}`
      default:
        return
    }
  }

  const handleCheck = () => {
    setIsChecked(!isChecked)
    handleProductChange(data.sku)
  }

  return (
    <div className='product-item'>
      <input
        type='checkbox'
        className='delete-checkbox product-item__checkbox'
        checked={isChecked}
        onChange={handleCheck}
      />
      <div className='product-item__sku'>{data.sku}</div>
      <div className='product-item__name'>{data.name}</div>
      <div className='product-item__price'>{data.price} $</div>
      <div className='product-item__info'>{getProductInfo(data)}</div>
    </div>
  )
}
