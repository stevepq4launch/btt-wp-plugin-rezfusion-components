import React from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import SleepingArrangement from '@propertybrands/btt-bluetent-components/components/Rooms/SleepingArrangement';

const element = document.querySelector('.sleeping-arrangements');
if (element) {
  const rooms = JSON.parse(element.dataset.rezfusionRooms.toString());
  const StyledDiv = styled.div`
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-row-gap: 1rem;
    grid-column-gap: 1rem;
    margin: 1rem 0;
  `;
  if (Array.isArray(rooms) && rooms.length) {
    const Rooms = () => (
      <StyledDiv>
        {/* eslint-disable-next-line react/jsx-props-no-spreading */}
        {rooms.map((room) => <SleepingArrangement {...room} key={room.name} />)}
      </StyledDiv>
    );
    ReactDOM.render(<Rooms />, element);
  }
}
